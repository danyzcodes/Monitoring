<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EbisManualInput;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\EbisPlanningOrder;
use App\Models\EbisPlanningProgressLog;
use App\Services\TelegramService;

class AdminController extends Controller
{
    public function sendDailyTelegramReport()
    {
        try {
            (new TelegramService())->sendDailyReport();
            
            
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Laporan harian berhasil dikirim ke Telegram!']);
            }
            
            return back()->with('success', 'Laporan harian berhasil dikirim ke Telegram!');
        } catch (\Exception $e) {
            \Log::error('Gagal kirim laporan harian Telegram via UI: ' . $e->getMessage());
            
            
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengirim laporan Telegram. Cek logs.'], 500);
            }
            
            return back()->with('error', 'Gagal mengirim laporan Telegram. Cek logs.');
        }
    }

    public function dashboard()
    {
        

        
        $totalDeployment = EbisManualInput::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        
        $lastMonthDeployment = EbisManualInput::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        
        $trendPercentage = 0;
        if ($lastMonthDeployment > 0) {
            $trendPercentage = (($totalDeployment - $lastMonthDeployment) / $lastMonthDeployment) * 100;
        }

        
        $statusCounts = DB::table('ebis_manual_inputs')
            ->leftJoin('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->select('ebis_planning_orders.status_order', DB::raw('count(*) as total'))
            ->groupBy('ebis_planning_orders.status_order')
            ->pluck('total', 'status_order');

        $totalAll = $statusCounts->sum();
        
        $totalSuccess = 0;
        $totalOnProcess = 0;
        $pendingReview = 0;
        $issuesReported = 0;
        $totalFailed = 0;

        $onProcessKeywords = ['progress', 'survey', 'inisiasi', 'validasi', 'drm', 'matdev', 'instalasi'];
        $pendingKeywords = ['pending', 'wait'];
        $issueKeywords = ['kendala', 'gagal', 'cancel'];
        $failedKeywords = ['gagal', 'cancel'];

        foreach ($statusCounts as $status => $count) {
            if (!$status) continue;
            
            $statusLower = strtolower($status);
            
            if ($statusLower === 'success') {
                $totalSuccess += $count;
            }
            
            foreach ($onProcessKeywords as $keyword) {
                if (strpos($statusLower, $keyword) !== false) {
                    $totalOnProcess += $count;
                    break;
                }
            }
            
            foreach ($pendingKeywords as $keyword) {
                if (strpos($statusLower, $keyword) !== false) {
                    $pendingReview += $count;
                    break;
                }
            }
            
            if (in_array($statusLower, $issueKeywords)) {
                $issuesReported += $count;
            }
            
            if (in_array($statusLower, $failedKeywords)) {
                $totalFailed += $count;
            }
        }
        $successRate = $totalAll > 0 ? ($totalSuccess / $totalAll) * 100 : 0;
        $failureRate = $totalAll > 0 ? ($totalFailed / $totalAll) * 100 : 0;


        

        
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();
        $trendData = EbisManualInput::select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', $sevenDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        
        $trendLabels = [];
        $trendValues = [];
        
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayLabel = Carbon::now()->subDays($i)->locale('id')->shortDayName . ' ' . Carbon::now()->subDays($i)->format('d/m');
            
            $record = $trendData->firstWhere('date', $date);
            
            $trendLabels[] = $dayLabel;
            $trendValues[] = $record ? $record->total : 0;
        }

        
        
        $statusDistRaw = EbisManualInput::select('ebis_planning_orders.status_order as status_label', DB::raw('count(*) as total'))
            ->join('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->groupBy('status_label')
            ->pluck('total', 'status_label');

        
        $onProcessCount = 0;
        $onProcessKeywords = ['Progress', 'Survey', 'Inisiasi', 'Validasi', 'Drm', 'Matdev', 'Instalasi'];
        
        foreach ($statusDistRaw as $label => $count) {
            foreach ($onProcessKeywords as $keyword) {
                if (stripos($label, $keyword) !== false) {
                    $onProcessCount += $count;
                    break; 
                }
            }
        }

        $statusDist = [
            'Success' => $statusDistRaw['Success'] ?? 0,
            'On Process' => $onProcessCount,
            'Pending' => $statusDistRaw['Pending'] ?? 0,
            'Issues' => ($statusDistRaw['Kendala'] ?? 0) + ($statusDistRaw['Gagal'] ?? 0) + ($statusDistRaw['Cancel'] ?? 0)
        ];

        
        
        $recentDeployments = EbisManualInput::with('planning')->latest()->take(5)->get();


        
        $waitingUsers = User::where('role', 'waiting')->take(5)->get();


        
        $todayVal = Carbon::today();
        $daily_cap = 3; $weekly_cap = 15; $monthly_cap = 60;
        
        $topMitrasBase = EbisManualInput::select('nama_mitra', DB::raw('count(*) as total'))
            ->whereNotNull('nama_mitra')->where('nama_mitra', '!=', '')
            ->groupBy('nama_mitra')->orderByDesc('total')->limit(3)->get();
            
        $topMitraNames = $topMitrasBase->pluck('nama_mitra')->toArray();
        
        $dailyCounts = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereDate('created_at', $todayVal)
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('count(*) as total'))
                ->pluck('total', 'nama_mitra')
            : collect();

        $weeklyCounts = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereBetween('created_at', [$todayVal->copy()->startOfWeek(), $todayVal->copy()->endOfWeek()])
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('count(*) as total'))
                ->pluck('total', 'nama_mitra')
            : collect();

        $monthlyCounts = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereMonth('created_at', $todayVal->month)
                ->whereYear('created_at', $todayVal->year)
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('count(*) as total'))
                ->pluck('total', 'nama_mitra')
            : collect();

        $avgDays = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereNotNull('tanggal_update_progres')
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('AVG(DATEDIFF(tanggal_update_progres, created_at)) as avg_days'))
                ->pluck('avg_days', 'nama_mitra')
            : collect();

        $topMitras = $topMitrasBase->map(function ($m) use ($todayVal, $daily_cap, $weekly_cap, $monthly_cap, $dailyCounts, $weeklyCounts, $monthlyCounts, $avgDays) {
            $name = $m->nama_mitra;
            $daily = $dailyCounts[$name] ?? 0;
            $weekly = $weeklyCounts[$name] ?? 0;
            $monthly = $monthlyCounts[$name] ?? 0;
            $avgDaysVal = $avgDays[$name] ?? null;
            return [
                'name' => $name, 
                'total' => $m->total, 
                'daily' => $daily, 
                'weekly' => $weekly, 
                'monthly' => $monthly, 
                'daily_cap' => $daily_cap, 
                'weekly_cap' => $weekly_cap, 
                'monthly_cap' => $monthly_cap, 
                'avg_time' => $avgDaysVal ? round($avgDaysVal) . ' hari' : 'N/A'
            ];
        });

        
        $liveTracking = EbisPlanningProgressLog::with(['user', 'planning.manualInput'])
            ->latest()
            ->take(10)
            ->get();

        
        $today = Carbon::now()->startOfDay();
        $todayStr = $today->format('Y-m-d');
        
        $overdueCommitmentsRaw = EbisManualInput::with('planning')
            ->whereHas('planning', function ($q) {
                $q->whereNotIn('status_order', ['Success', 'Gagal', 'Cancel']);
            })
            ->whereNotIn('progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
            ->whereNotNull('data->commitment_date')
            ->where('data->commitment_date', '<', $todayStr)
            ->get();

        $userIds = $overdueCommitmentsRaw->map(function ($item) {
            return $item->data['commitment_updated_by'] ?? null;
        })->filter()->unique()->toArray();

        $users = !empty($userIds)
            ? \App\Models\User::whereIn('id', $userIds)->get()->keyBy('id')
            : collect();

        $overdueCommitments = $overdueCommitmentsRaw->map(function ($item) use ($users) {
            $userId = $item->data['commitment_updated_by'] ?? null;
            $userName = $userId && isset($users[$userId])
                ? ($users[$userId]->name ?? 'Unknown')
                : 'Unknown';

            return [
                'id'              => $item->id,
                'star_click_id'   => $item->star_click_id,
                'nama_customer'   => $item->nama_customer,
                'commitment_date' => $item->data['commitment_date'],
                'updated_by'      => $userName,
                'days_overdue'    => (int) Carbon::parse($item->data['commitment_date'])->startOfDay()->diffInDays(now()->startOfDay()),
                'status'          => optional($item->planning)->status_order ?? '-',
            ];
        })
        ->sortByDesc('days_overdue')
        ->values();

        
        $trendFilterOptions = [
            'datels' => \App\Models\MasterDatel::orderBy('nama_datel')->pluck('nama_datel'),
            'stos'   => \App\Models\MasterSto::orderBy('nama_sto')->pluck('nama_sto'),
            'mitras' => \App\Models\MasterMitra::orderBy('nama_mitra')->pluck('nama_mitra'),
        ];

        return view('admin.dashboard', compact(
            'totalDeployment',
            'trendPercentage',
            'successRate',
            'failureRate',
            'totalOnProcess',
            'pendingReview',
            'issuesReported',
            'trendLabels',
            'trendValues',
            'statusDist',
            'recentDeployments',
            'waitingUsers',
            'topMitras',
            'liveTracking',
            'overdueCommitments',
            'trendFilterOptions'
        ));
    }
    public function getEnterpriseStats()
    {
        

        
        
        $activeOrders = EbisManualInput::whereHas('planning', function ($q) {
                $q->whereNotIn('status_order', ['Success', 'Gagal', 'Cancel']);
            })
            ->whereNotNull('created_at') 
            ->select('created_at')
            ->get();

        $aging = [
            '0-3' => 0,
            '4-7' => 0,
            '8-14' => 0,
            '>14' => 0
        ];

        foreach ($activeOrders as $order) {
            if (!$order->created_at) continue; 
            $days = $order->created_at->diffInDays($now);
            if ($days <= 3) $aging['0-3']++;
            elseif ($days <= 7) $aging['4-7']++;
            elseif ($days <= 14) $aging['8-14']++;
            else $aging['>14']++;
        }

        
        $kpiTarget = 100; 
        $kpiRealization = $totalDeployment; 
        
        
        
        $monthlySuccess = EbisManualInput::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereHas('planning', function ($q) {
                $q->where('status_order', 'Success');
            })->count();
        
        $kpiPercentage = $kpiTarget > 0 ? ($monthlySuccess / $kpiTarget) * 100 : 0;


        
        $totalFailed = EbisManualInput::whereHas('planning', function ($q) {
             $q->whereIn('status_order', ['Gagal', 'Cancel']);
        })->count();
        $failureRate = $totalAll > 0 ? ($totalFailed / $totalAll) * 100 : 0;


        

        
        $recentDeployments = EbisManualInput::with('planning')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($deploy) {
                return [
                    'time_ago' => $deploy->created_at->diffForHumans(),
                    'star_click_id' => $deploy->star_click_id,
                    'sto' => strtoupper($deploy->sto),
                    'mitra' => $deploy->nama_mitra,
                    'status' => optional($deploy->planning)->status_order ?? 'Unknown',
                    'status_class' => $this->getStatusClass(optional($deploy->planning)->status_order ?? 'Unknown')
                ];
            });

        
        $topMitras = EbisManualInput::select('nama_mitra', DB::raw('count(*) as total_jobs'))
            ->whereNotNull('nama_mitra')
            ->where('nama_mitra', '!=', '')
            ->groupBy('nama_mitra')
            ->orderByDesc('total_jobs')
            ->take(3)
            ->get()
            ->map(function($mitra) {
                $checkSuccess = EbisManualInput::where('nama_mitra', $mitra->nama_mitra)
                    ->whereHas('planning', function ($q) {
                        $q->where('status_order', 'LIKE', '%Success%');
                    })
                    ->count();
                $rate = $mitra->total_jobs > 0 ? ($checkSuccess / $mitra->total_jobs) * 100 : 0;
                return [
                    'name' => $mitra->nama_mitra,
                    'rate' => round($rate, 1),
                    'total' => $mitra->total_jobs
                ];
            });

        
        $statusDist = [
            'Success' => $totalSuccess,
            'On Process' => $totalOnProcess,
            'Pending' => $pendingReview,
            'Issues' => $issuesReported
        ];

        return response()->json([
            
            'totalDeployment' => number_format($totalDeployment),
            'trendPercentage' => number_format($trendPercentage, 1),
            'isTrendPositive' => $trendPercentage >= 0,
            'successRate' => number_format($successRate, 1),
            'totalOnProcess' => number_format($totalOnProcess),
            'pendingReview' => number_format($pendingReview),
            'issuesReported' => number_format($issuesReported),
            
            'overSLACount' => $overSLACount,
            'aging' => $aging,
            'kpi' => [
                'target' => $kpiTarget,
                'realization' => $monthlySuccess,
                'percentage' => round($kpiPercentage, 1)
            ],
            'failureRate' => round($failureRate, 1),
            
            'recentDeployments' => $recentDeployments,
            'statusDist' => array_values($statusDist),
            'topMitras' => $topMitras
        ]);
    }
    public function getRealtimeStats()
    {
        
        $totalDeployment = EbisManualInput::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $lastMonthDeployment = EbisManualInput::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        $trendPercentage = 0;
        if ($lastMonthDeployment > 0) {
            $trendPercentage = (($totalDeployment - $lastMonthDeployment) / $lastMonthDeployment) * 100;
        }

        $statusCounts = DB::table('ebis_manual_inputs')
            ->leftJoin('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->select('ebis_planning_orders.status_order', DB::raw('count(*) as total'))
            ->groupBy('ebis_planning_orders.status_order')
            ->pluck('total', 'status_order');

        $totalAll = $statusCounts->sum();
        
        $totalSuccess = 0;
        $totalOnProcess = 0;
        $pendingReview = 0;
        $issuesReported = 0;
        $totalFailed = 0;

        $onProcessKeywords = ['progress', 'survey', 'inisiasi', 'validasi', 'drm', 'matdev', 'instalasi'];
        $pendingKeywords = ['pending', 'wait'];
        $issueKeywords = ['kendala', 'gagal', 'cancel'];
        $failedKeywords = ['gagal', 'cancel'];

        foreach ($statusCounts as $status => $count) {
            if (!$status) continue;
            
            $statusLower = strtolower($status);
            
            if ($statusLower === 'success') {
                $totalSuccess += $count;
            }
            
            foreach ($onProcessKeywords as $keyword) {
                if (strpos($statusLower, $keyword) !== false) {
                    $totalOnProcess += $count;
                    break;
                }
            }
            
            foreach ($pendingKeywords as $keyword) {
                if (strpos($statusLower, $keyword) !== false) {
                    $pendingReview += $count;
                    break;
                }
            }
            
            if (in_array($statusLower, $issueKeywords)) {
                $issuesReported += $count;
            }
            
            if (in_array($statusLower, $failedKeywords)) {
                $totalFailed += $count;
            }
        }
        $successRate = $totalAll > 0 ? ($totalSuccess / $totalAll) * 100 : 0;

        
        $recentDeployments = EbisManualInput::with('planning')
            ->latest()
            ->take(10) 
            ->get()
            ->map(function ($deploy) {
                return [
                    'time_ago' => $deploy->created_at->diffForHumans(),
                    'star_click_id' => $deploy->star_click_id,
                    'sto' => strtoupper($deploy->sto),
                    'mitra' => $deploy->nama_mitra,
                    'status' => optional($deploy->planning)->status_order ?? 'Unknown',
                    'status_class' => $this->getStatusClass(optional($deploy->planning)->status_order ?? 'Unknown')
                ];
            });

        
        $statusDist = [
            'Success' => $totalSuccess,
            'On Process' => $totalOnProcess,
            'Pending' => $pendingReview,
            'Issues' => $issuesReported
        ];

        
        

        
        $topMitrasBase = EbisManualInput::select('nama_mitra', DB::raw('count(*) as total_jobs'))
            ->whereNotNull('nama_mitra')
            ->where('nama_mitra', '!=', '')
            ->groupBy('nama_mitra')
            ->orderByDesc('total_jobs')
            ->take(3)
            ->get();
            
        $topMitraNames = $topMitrasBase->pluck('nama_mitra')->toArray();
        
        $successCounts = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereHas('planning', function ($q) {
                    $q->where('status_order', 'LIKE', '%Success%');
                })
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('count(*) as total'))
                ->pluck('total', 'nama_mitra')
            : collect();
            
        $topMitras = $topMitrasBase->map(function ($mitra) use ($successCounts) {
            $name = $mitra->nama_mitra;
            $successCount = $successCounts[$name] ?? 0;
            $rate = $mitra->total_jobs > 0 ? ($successCount / $mitra->total_jobs) * 100 : 0;
            
            return [
                'name' => $name,
                'rate' => round($rate, 1),
                'total' => $mitra->total_jobs
            ];
        });

        return response()->json([
            'totalDeployment' => number_format($totalDeployment),
            'trendPercentage' => number_format($trendPercentage, 1),
            'isTrendPositive' => $trendPercentage >= 0,
            'successRate' => number_format($successRate, 1),
            'totalOnProcess' => number_format($totalOnProcess),
            'pendingReview' => number_format($pendingReview),
            'issuesReported' => number_format($issuesReported),
            'recentDeployments' => $recentDeployments,
            'statusDist' => array_values($statusDist),
            'topMitras' => $topMitras
        ]);
    }

    public function getLiveTracking()
    {
        $data = cache()->remember('dashboard.live-tracking', 10, function () {
            $logs = EbisPlanningProgressLog::with(['user', 'planning'])
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($log) {
                    return [
                        'user_name'     => $log->user->name ?? 'System',
                        'user_initials' => strtoupper(substr($log->user->name ?? '?', 0, 2)),
                        'star_click_id' => $log->planning->star_click_id ?? 'N/A',
                        'progres'       => $log->progres,
                        'time_ago'      => $log->created_at->diffForHumans(null, true, true),
                        'commitment_date' => isset($log->data['commitment_date'])
                            ? \Carbon\Carbon::parse($log->data['commitment_date'])->format('d M')
                            : null,
                    ];
                });

            $waitingUsers = User::where('role', 'waiting')->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'initial' => strtoupper(substr($user->name, 0, 1)),
                    'requested_role' => $user->requested_role ? ucfirst($user->requested_role) : null,
                    'time_ago' => $user->created_at->diffForHumans(),
                    'route' => route('admin.users')
                ];
            });

            return [
                'activities' => $logs,
                'waiting' => $waitingUsers
            ];
        });

        return response()->json($data);
    }

    public function getTrendData(Request $request)
    {
        $filter = $request->get('filter', 'daily'); 
        $datel  = $request->get('datel');
        $sto    = $request->get('sto');
        $mitra  = $request->get('mitra');

        $labels = [];
        $values = [];

        
        $baseQuery = function () use ($datel, $sto, $mitra) {
            $q = EbisManualInput::query();
            if ($datel) $q->where('datel', $datel);
            if ($sto)   $q->where('sto', $sto);
            if ($mitra) $q->where('nama_mitra', $mitra);
            return $q;
        };

        if ($filter === 'monthly') {
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->locale('id')->monthName;
                $values[] = $baseQuery()
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count();
            }
        } elseif ($filter === 'weekly') {
            for ($i = 3; $i >= 0; $i--) {
                $weekNum = 4 - $i;
                $start = Carbon::now()->subWeeks($i)->startOfWeek();
                $end = Carbon::now()->subWeeks($i)->endOfWeek();
                $labels[] = "Minggu " . $weekNum . " (" . $start->format('d/m') . ")";
                $values[] = $baseQuery()->whereBetween('created_at', [$start, $end])->count();
            }
        } else {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->locale('id')->shortDayName . ' ' . $date->format('d/m');
                $values[] = $baseQuery()->whereDate('created_at', $date->format('Y-m-d'))->count();
            }
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    
    public function progressOverview(Request $request)
    {
        
        $filterStoArr   = array_filter((array) $request->get('sto', []));
        $filterDatelArr = array_filter((array) $request->get('datel', []));
        $filterMitraArr = array_filter((array) $request->get('mitra', []));

        $progA = $request->get('prog_a');
        $progB = $request->get('prog_b');

        $filterYear   = $request->get('year', now()->year);
        $filterMonth  = $request->get('month');
        $filterDateFrom = $request->get('date_from');
        $filterDateTo   = $request->get('date_to');

        
        $filterSto   = count($filterStoArr) === 1 ? $filterStoArr[0] : null;
        $filterDatel = count($filterDatelArr) === 1 ? $filterDatelArr[0] : null;
        $filterMitra = count($filterMitraArr) === 1 ? $filterMitraArr[0] : null;

        
        $baseQuery = function () use ($filterStoArr, $filterDatelArr, $filterMitraArr, $filterYear, $filterMonth, $filterDateFrom, $filterDateTo) {
            $q = EbisManualInput::query();
            if (!empty($filterStoArr))   $q->whereIn('ebis_manual_inputs.sto', $filterStoArr);
            if (!empty($filterDatelArr)) $q->whereIn('ebis_manual_inputs.datel', $filterDatelArr);
            if (!empty($filterMitraArr)) $q->whereIn('ebis_manual_inputs.nama_mitra', $filterMitraArr);

            // Date range filter takes priority over year/month
            if ($filterDateFrom || $filterDateTo) {
                $from = $filterDateFrom ? \Carbon\Carbon::parse($filterDateFrom)->startOfDay() : \Carbon\Carbon::create(2000, 1, 1);
                $to   = $filterDateTo   ? \Carbon\Carbon::parse($filterDateTo)->endOfDay()   : now();
                $q->whereBetween('ebis_manual_inputs.created_at', [$from, $to]);
            } else {
                if ($filterYear) {
                    $q->whereYear('ebis_manual_inputs.created_at', $filterYear);
                }
                if ($filterMonth && $filterMonth !== 'all') {
                    $q->whereMonth('ebis_manual_inputs.created_at', $filterMonth);
                }
            }
            return $q;
        };

        
        $stoList   = \App\Models\MasterSto::orderBy('nama_sto')->pluck('nama_sto');
        $datelList = \App\Models\MasterDatel::orderBy('nama_datel')->pluck('nama_datel');
        $mitraList = \App\Models\MasterMitra::orderBy('nama_mitra')->pluck('nama_mitra');

        
        $stages = [
            'ON DESK', 'SURVEY', 'PERIJINAN', 'DRM', 'APPROVED BY EBIS',
            'MATDEV', 'INSTALASI', 'SELESAI FISIK', 'GOLIVE',
            'PS', 'KENDALA', 'UJI TERIMA', 'REKON',
        ];

        
        
        $datels = \App\Models\MasterDatel::orderBy('nama_datel')
            ->pluck('nama_datel')
            ->map(fn($d) => strtoupper($d))
            ->toArray();

        
        $rawStackedCounts = $baseQuery()
            ->select('datel', 'progres', DB::raw('count(*) as total'))
            ->whereNotNull('datel')->where('datel', '!=', '')
            ->whereNotNull('progres')->where('progres', '!=', '')
            ->groupBy('datel', 'progres')
            ->get();

        
        $datelLabels = array_values(array_unique($datels));
        $stackedData = [];
        
        foreach ($stages as $stage) {
            $stackedData[$stage] = [];
            foreach ($datelLabels as $datel) {
                
                $match = $rawStackedCounts->first(function ($item) use ($datel, $stage) {
                    return strtoupper($item->datel) === $datel && strtoupper($item->progres) === $stage;
                });
                $stackedData[$stage][] = $match ? $match->total : 0;
            }
        }

        
        $totalAll       = (clone $baseQuery())->count();
        $totalSelesai   = (clone $baseQuery())->whereNotNull('progres')->whereIn('progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])->count();
        
        $todayStr = now()->startOfDay()->format('Y-m-d');
        $overdueQuery = (clone $baseQuery())
            ->whereHas('planning', function($q) {
                $q->whereNotIn('status_order', ['Success', 'Gagal', 'Cancel']);
            })
            ->whereNotIn('ebis_manual_inputs.progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
            ->whereNotNull('data')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.commitment_date')) IS NOT NULL")
            ->whereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.commitment_date')), '%Y-%m-%d') < ?", [$todayStr]);

        $totalOverdue = $overdueQuery->count();
            
        
        $totalOnTrack   = $totalAll - $totalOverdue;
        if ($totalOnTrack < 0) $totalOnTrack = 0;

        
        $topProgress = null;
        $topProgressCount = 0;
        
        
        $datelTotals = [];
        foreach ($rawStackedCounts as $item) {
            $datel = strtoupper($item->datel);
            if (!isset($datelTotals[$datel])) $datelTotals[$datel] = 0;
            $datelTotals[$datel] += $item->total;
        }

        foreach ($datelTotals as $datel => $count) {
            if ($count > $topProgressCount) {
                $topProgressCount = $count;
                $topProgress = strtoupper($datel);
            }
        }

        
        $recentUpdates = $baseQuery()
            ->whereNotNull('progres')
            ->where('progres', '!=', '')
            ->orderByDesc('updated_at')
            ->take(10)
            ->get(['star_click_id', 'nama_customer', 'progres', 'datel', 'sto', 'updated_at']);

        
        $ihldQuery = clone $baseQuery();
        $rawIhldCounts = $ihldQuery->select('ebis_manual_inputs.datel', 'ebis_planning_orders.status_order', DB::raw('count(*) as total'))
            ->join('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->whereNotNull('ebis_manual_inputs.datel')->where('ebis_manual_inputs.datel', '!=', '')
            ->whereNotNull('ebis_planning_orders.status_order')
            ->groupBy('ebis_manual_inputs.datel', 'ebis_planning_orders.status_order')
            ->get();

        $ihldStatuses = $rawIhldCounts->pluck('status_order')->unique()->values()->toArray();
        $ihldStackedData = [];

        foreach ($ihldStatuses as $status) {
            $ihldStackedData[$status] = [];
            foreach ($datelLabels as $datel) {
                $match = $rawIhldCounts->first(function ($item) use ($datel, $status) {
                    return strtoupper($item->datel) === $datel && $item->status_order === $status;
                });
                $ihldStackedData[$status][] = $match ? $match->total : 0;
            }
        }

        $avgDurationAB = null;
        if ($progA && $progB) {
            $starClickIds = (clone $baseQuery())->pluck('ebis_manual_inputs.star_click_id');
            if ($starClickIds->isNotEmpty()) {
                $avgQuery = DB::table('ebis_planning_progress_logs as log_a')
                    ->join('ebis_planning_progress_logs as log_b', 'log_a.ebis_planning_order_id', '=', 'log_b.ebis_planning_order_id')
                    ->join('ebis_planning_orders as p', 'log_a.ebis_planning_order_id', '=', 'p.id')
                    ->whereIn('p.star_click_id', $starClickIds)
                    ->where('log_a.progres', $progA)
                    ->where('log_b.progres', $progB)
                    ->whereRaw('log_b.created_at >= log_a.created_at')
                    ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, log_a.created_at, log_b.created_at)) as avg_minutes')
                    ->first();
                    
                if ($avgQuery && $avgQuery->avg_minutes !== null) {
                    $totalMinutesAB = abs($avgQuery->avg_minutes);
                    $daysAB = floor($totalMinutesAB / 1440);
                    $hoursAB = floor(($totalMinutesAB % 1440) / 60);
                    
                    $avgDurationAB = "{$daysAB} Hari";
                    if ($hoursAB > 0) $avgDurationAB .= " {$hoursAB} Jam";
                }
            }
        }

        $mitraStatsRaw = (clone $baseQuery())
            ->whereIn('ebis_manual_inputs.progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
            ->whereNotNull('ebis_manual_inputs.nama_mitra')
            ->where('ebis_manual_inputs.nama_mitra', '!=', '')
            ->leftJoin('ebis_planning_orders as p', 'ebis_manual_inputs.star_click_id', '=', 'p.star_click_id')
            ->select(
                'ebis_manual_inputs.nama_mitra',
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(ABS(TIMESTAMPDIFF(MINUTE, ebis_manual_inputs.created_at, COALESCE(
                    (
                        SELECT MIN(l.created_at) 
                        FROM ebis_planning_progress_logs l 
                        WHERE l.ebis_planning_order_id = p.id
                          AND l.progres IN (\'GOLIVE\', \'PS\', \'UJI TERIMA\', \'REKON\')
                    ),
                    ebis_manual_inputs.tanggal_update_progres,
                    ebis_manual_inputs.created_at
                )))) as sum_minutes')
            )
            ->groupBy('ebis_manual_inputs.nama_mitra')
            ->get();

        $mitraAvgArray = [];
        foreach ($mitraStatsRaw as $row) {
            $mitra = $row->nama_mitra;
            $count = $row->total_count;
            $totalMinutes = $row->sum_minutes ?? 0;

            if ($count > 0) {
                $avgMinutes = $totalMinutes / $count;
                $avgDaysRaw = $avgMinutes / 1440;
                
                $days = floor($avgMinutes / 1440);
                $hours = floor(($avgMinutes % 1440) / 60);
                
                $labelStr = "{$days} Hari";
                if ($hours > 0) $labelStr .= " {$hours} Jam";

                
                $totalDays = floor($totalMinutes / 1440);
                $totalHours = floor(($totalMinutes % 1440) / 60);
                $totalLabel = "{$totalDays} Hari";
                if ($totalHours > 0) $totalLabel .= " {$totalHours} Jam";

                $mitraAvgArray[] = [
                    'mitra' => $mitra,
                    'avg_raw' => round($avgDaysRaw, 2),
                    'avg_label' => $labelStr,
                    'count' => $count,
                    'total_minutes' => $totalMinutes,
                    'total_label' => $totalLabel
                ];
            }
        }

        usort($mitraAvgArray, function($a, $b) {
            return $b['avg_raw'] <=> $a['avg_raw'];
        });

        $mitraAvgLabels = [];
        $mitraAvgValues = [];
        $mitraAvgTextLabels = [];

        foreach ($mitraAvgArray as $item) {
            $mitraAvgLabels[] = $item['mitra'];
            $mitraAvgValues[] = $item['avg_raw'];
            $mitraAvgTextLabels[] = $item['avg_label'];
        }

        
        $timelineData = [];
        if (!empty($filterMitraArr)) {
            $mitrasToCompare = $filterMitraArr;

            
            $compareOrders = (clone $baseQuery())
                ->whereIn('ebis_manual_inputs.nama_mitra', $mitrasToCompare)
                ->with([
                    'planning' => function($q) {
                        $q->select('id', 'star_click_id');
                    },
                    'planning.logs' => function($q) {
                        $q->select('id', 'ebis_planning_order_id', 'progres', 'created_at')
                          ->orderBy('created_at', 'asc');
                    }
                ])
                ->get(['ebis_manual_inputs.id', 'ebis_manual_inputs.star_click_id', 'ebis_manual_inputs.nama_mitra', 'ebis_manual_inputs.created_at']);

            
            $groupedOrders = $compareOrders->groupBy('nama_mitra');

            $linearStages = [
                'ON DESK', 'SURVEY', 'PERIJINAN', 'DRM', 'APPROVED BY EBIS',
                'MATDEV', 'INSTALASI', 'SELESAI FISIK', 'GOLIVE',
                'PS', 'UJI TERIMA', 'REKON'
            ];

            foreach ($mitrasToCompare as $mitraName) {
                $orders = $groupedOrders->get($mitraName, collect());
                $totalOrdersCount = $orders->count();
                
                
                $transitions = [];
                for ($i = 0; $i < count($linearStages) - 1; $i++) {
                    $transitions[$i] = ['sum_minutes' => 0, 'count' => 0];
                }
                
                foreach ($orders as $order) {
                    $stagesTimes = [];
                    
                    
                    if ($order->created_at) {
                        $stagesTimes['ON DESK'] = $order->created_at;
                    }
                    
                    $logs = $order->planning?->logs ?? collect();
                    foreach ($logs as $log) {
                        $stageName = strtoupper($log->progres);
                        if (!isset($stagesTimes[$stageName])) {
                            $stagesTimes[$stageName] = $log->created_at;
                        }
                    }
                    
                    
                    for ($i = 0; $i < count($linearStages) - 1; $i++) {
                        $stageA = $linearStages[$i];
                        $stageB = $linearStages[$i + 1];
                        
                        if (isset($stagesTimes[$stageA]) && isset($stagesTimes[$stageB])) {
                            $timeA = \Carbon\Carbon::parse($stagesTimes[$stageA]);
                            $timeB = \Carbon\Carbon::parse($stagesTimes[$stageB]);
                            
                            $diffMinutes = abs($timeA->diffInMinutes($timeB, false));
                            
                            $transitions[$i]['sum_minutes'] += $diffMinutes;
                            $transitions[$i]['count']++;
                        }
                    }
                }
                
                
                $steps = [];
                
                
                $steps[] = [
                    'stage' => 'ON DESK',
                    'duration' => 'Mulai',
                    'time' => 'Referensi Awal',
                    'sample_size' => $totalOrdersCount
                ];
                
                for ($i = 0; $i < count($linearStages) - 1; $i++) {
                    $stageB = $linearStages[$i + 1];
                    $stats = $transitions[$i];
                    
                    if ($stats['count'] > 0) {
                        $avgMinutes = $stats['sum_minutes'] / $stats['count'];
                        
                        $days  = (int) floor($avgMinutes / 1440);
                        $rem   = (int) $avgMinutes % 1440;
                        $hours = (int) floor($rem / 60);
                        $mins  = (int) ($rem % 60);
                        
                        $durationLabel = "";
                        if ($days > 0) {
                            $durationLabel .= "{$days} hari";
                        }
                        if ($hours > 0) {
                            $durationLabel .= ($durationLabel ? " " : "") . "{$hours} jam";
                        }
                        if ($mins > 0) {
                            $durationLabel .= ($durationLabel ? " " : "") . "{$mins} menit";
                        }
                        if ($days == 0 && $hours == 0 && $mins == 0) {
                            $durationLabel = "< 1 menit";
                        }
                        
                        $steps[] = [
                            'stage' => $stageB,
                            'duration' => "+ " . $durationLabel,
                            'time' => "Rata-rata dari {$stats['count']} order",
                            'sample_size' => $stats['count']
                        ];
                    } else {
                        $steps[] = [
                            'stage' => $stageB,
                            'duration' => "N/A",
                            'time' => "Tidak ada data",
                            'sample_size' => 0
                        ];
                    }
                }
                
                $timelineData[] = [
                    'mitra' => $mitraName,
                    'steps' => $steps,
                    'total_orders' => $totalOrdersCount
                ];
            }
        }

        
        $hasFilter = !empty($filterStoArr) || !empty($filterDatelArr) || !empty($filterMitraArr) || ($progA && $progB) || $filterMonth || $filterDateFrom || $filterDateTo;

        return view('deployment.progress-overview', compact(
            'datelLabels', 'stackedData', 'totalAll', 'totalOverdue', 'totalSelesai', 'totalOnTrack',
            'recentUpdates', 'stoList', 'datelList', 'mitraList',
            'filterSto', 'filterDatel', 'filterMitra',
            'filterStoArr', 'filterDatelArr', 'filterMitraArr', 'hasFilter',
            'topProgress', 'topProgressCount',
            'ihldStatuses', 'ihldStackedData',
            'progA', 'progB', 'avgDurationAB', 'mitraAvgLabels', 'mitraAvgValues', 'mitraAvgTextLabels', 'mitraAvgArray', 'stages',
            'filterYear', 'filterMonth', 'filterDateFrom', 'filterDateTo', 'timelineData'
        ));
    }

    private function getStatusClass($status)
    {
        if (stripos($status, 'Success') !== false) return 'bg-green-100 text-green-800';
        if (stripos($status, 'Pending') !== false || stripos($status, 'Wait') !== false) return 'bg-yellow-100 text-yellow-800';
        if (stripos($status, 'Kendala') !== false || stripos($status, 'Gagal') !== false) return 'bg-red-100 text-red-800';
        return 'bg-blue-100 text-blue-800'; 
    }

    public function getWorkloadDay(Request $request)
    {
        $year  = (int) $request->get('year',  now()->year);
        $month = (int) $request->get('month', now()->month);

        $firstDay  = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $lastDay   = $firstDay->copy()->endOfMonth();

        
        $logs = EbisPlanningProgressLog::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereIn(DB::raw('UPPER(progres)'), ['ON DESK', 'SURVEY', 'PERIJINAN', 'DRM', 'APPROVED BY EBIS', 'MATDEV', 'INSTALASI', 'SELESAI FISIK', 'GOLIVE', 'PS', 'KENDALA', 'UJI TERIMA', 'REKON'])
            ->with([
                'planning' => function($q) {
                    $q->select('id', 'star_click_id', 'nama_mitra');
                },
                'planning.manualInput' => function($q) {
                    $q->select('id', 'star_click_id', 'nama_mitra');
                }
            ])
            ->get(['id', 'ebis_planning_order_id', 'progres', 'created_at']);

        
        $ordersByDate = [];
        foreach ($logs as $log) {
            $d = Carbon::parse($log->created_at)->format('Y-m-d');
            $mitra = 'Tanpa Mitra';
            if ($log->planning) {
                if ($log->planning->manualInput && $log->planning->manualInput->nama_mitra) {
                    $mitra = $log->planning->manualInput->nama_mitra;
                } elseif ($log->planning->nama_mitra) {
                    $mitra = $log->planning->nama_mitra;
                }
            }
            $progres = strtoupper($log->progres);

            if (!isset($ordersByDate[$d])) $ordersByDate[$d] = [];
            if (!isset($ordersByDate[$d][$mitra])) {
                $ordersByDate[$d][$mitra] = [
                    'count'  => 0,
                    'stages' => []
                ];
            }
            $ordersByDate[$d][$mitra]['count']++;
            if (!in_array($progres, $ordersByDate[$d][$mitra]['stages'])) {
                $ordersByDate[$d][$mitra]['stages'][] = $progres;
            }
        }

        
        $startPad = ($firstDay->dayOfWeekIso - 1); 
        $endPad   = (7 - $lastDay->dayOfWeekIso) % 7;

        $days = [];

        
        for ($i = $startPad; $i > 0; $i--) {
            $d = $firstDay->copy()->subDays($i);
            $days[] = [
                'date'     => $d->format('Y-m-d'),
                'day_label'=> strtoupper(substr($d->locale('id')->isoFormat('ddd'), 0, 3)),
                'num_label'=> $d->format('j') . ' ' . $d->locale('id')->isoFormat('MMMM'),
                'count'    => 0,
                'details'  => [],
                'is_today' => false,
                'in_month' => false,
            ];
        }

        
        for ($i = 0; $i < $firstDay->daysInMonth; $i++) {
            $d = $firstDay->copy()->addDays($i);
            $key = $d->format('Y-m-d');
            $details = [];
            $total = 0;
            if (isset($ordersByDate[$key])) {
                foreach ($ordersByDate[$key] as $mitra => $data) {
                    $details[] = [
                        'mitra'   => $mitra,
                        'progres' => implode(', ', $data['stages']),
                        'stages'  => $data['stages'],
                        'count'   => $data['count']
                    ];
                    $total += $data['count'];
                }
                usort($details, fn($a, $b) => $b['count'] <=> $a['count']);
            }
            $days[] = [
                'date'     => $key,
                'day_label'=> strtoupper(substr($d->locale('id')->isoFormat('ddd'), 0, 3)),
                'num_label'=> $d->format('j') . ' ' . $d->locale('id')->isoFormat('MMM'),
                'count'    => $total,
                'details'  => $details,
                'is_today' => $d->isToday(),
                'in_month' => true,
            ];
        }

        
        for ($i = 1; $i <= $endPad; $i++) {
            $d = $lastDay->copy()->addDays($i);
            $days[] = [
                'date'     => $d->format('Y-m-d'),
                'day_label'=> strtoupper(substr($d->locale('id')->isoFormat('ddd'), 0, 3)),
                'num_label'=> $d->format('j') . ' ' . $d->locale('id')->isoFormat('MMM'),
                'count'    => 0,
                'details'  => [],
                'is_today' => false,
                'in_month' => false,
            ];
        }

        $maxOrders = count($logs) > 0 ? max(array_map(fn($d) => $d['count'], $days)) : 10;
        $globalCap = max($maxOrders, 10);

        return response()->json([
            'week_headers' => $days,
            'global_cap'   => $globalCap,
        ]);
    }

    public function workloadDetailsPage(Request $request)
    {
        $date = $request->get('date');
        $year = $request->get('year');
        $month = $request->get('month');

        if ($date) {
            $parsedDate = \Carbon\Carbon::parse($date);
            $year = $parsedDate->year;
            $month = $parsedDate->month;
        } else {
            $year = $year ?? now()->year;
            $month = $month ?? now()->month;
        }

        $week = $request->get('week');
        $mitra = $request->get('mitra');
        $progres = $request->get('progres');
        $search = $request->get('search');

        $query = EbisPlanningProgressLog::with(['user', 'planning.manualInput'])
            ->whereIn(DB::raw('UPPER(progres)'), ['SURVEY', 'PERIJINAN', 'MATDEV', 'INSTALASI', 'SELESAI FISIK']);

        
        if ($date) {
            $query->whereDate('created_at', $date);
        } else {
            
            if ($year && $year !== 'all') {
                $query->whereYear('created_at', $year);
            }

            
            if ($month && $month !== 'all') {
                $query->whereMonth('created_at', $month);
            }
        }

        
        if ($week && $week !== 'all') {
            if ($week == 1) {
                $query->whereRaw('DAY(created_at) BETWEEN 1 AND 7');
            } elseif ($week == 2) {
                $query->whereRaw('DAY(created_at) BETWEEN 8 AND 14');
            } elseif ($week == 3) {
                $query->whereRaw('DAY(created_at) BETWEEN 15 AND 21');
            } elseif ($week == 4) {
                $query->whereRaw('DAY(created_at) BETWEEN 22 AND 28');
            } elseif ($week == 5) {
                $query->whereRaw('DAY(created_at) >= 29');
            }
        }

        
        if ($mitra) {
            $mitras = array_filter((array) $mitra);
            if (!empty($mitras)) {
                $query->whereHas('planning', function ($q) use ($mitras) {
                    $q->whereIn('nama_mitra', $mitras)
                      ->orWhereHas('manualInput', function ($m) use ($mitras) {
                          $m->whereIn('nama_mitra', $mitras);
                      });
                });
            }
        }

        
        if ($progres) {
            $query->where('progres', $progres);
        }

        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('planning', function ($p) use ($search) {
                    $p->where('star_click_id', 'like', "%{$search}%")
                      ->orWhere('nama_customer', 'like', "%{$search}%")
                      ->orWhereHas('manualInput', function ($m) use ($search) {
                          $m->where('nama_customer', 'like', "%{$search}%")
                            ->orWhere('star_click_id', 'like', "%{$search}%");
                      });
                });
            });
        }

        
        $logs = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        
        $mitraList = \App\Models\MasterMitra::orderBy('nama_mitra')->pluck('nama_mitra');
        $yearsList = range(now()->year - 5, now()->year + 2);
        $stagesList = ['SURVEY', 'PERIJINAN', 'MATDEV', 'INSTALASI', 'SELESAI FISIK'];

        return view('deployment.workload', compact(
            'logs',
            'mitraList',
            'yearsList',
            'stagesList',
            'year',
            'month',
            'week',
            'mitra',
            'progres',
            'search'
        ));
    }

    public function getTopMitras(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $d    = Carbon::parse($date);

        $daily_cap   = 3;
        $weekly_cap  = 15;
        $monthly_cap = 60;

        $topMitrasBase = EbisManualInput::select('nama_mitra', DB::raw('count(*) as total'))
            ->whereNotNull('nama_mitra')->where('nama_mitra', '!=', '')
            ->groupBy('nama_mitra')->orderByDesc('total')->limit(3)->get();
            
        $topMitraNames = $topMitrasBase->pluck('nama_mitra')->toArray();
        
        $dailyCounts = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereDate('created_at', $d)
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('count(*) as total'))
                ->pluck('total', 'nama_mitra')
            : collect();

        $weeklyCounts = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereBetween('created_at', [$d->copy()->startOfWeek(), $d->copy()->endOfWeek()])
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('count(*) as total'))
                ->pluck('total', 'nama_mitra')
            : collect();

        $monthlyCounts = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereMonth('created_at', $d->month)
                ->whereYear('created_at', $d->year)
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('count(*) as total'))
                ->pluck('total', 'nama_mitra')
            : collect();

        $avgDays = !empty($topMitraNames)
            ? EbisManualInput::whereIn('nama_mitra', $topMitraNames)
                ->whereNotNull('tanggal_update_progres')
                ->groupBy('nama_mitra')
                ->select('nama_mitra', DB::raw('AVG(DATEDIFF(tanggal_update_progres, created_at)) as avg_days'))
                ->pluck('avg_days', 'nama_mitra')
            : collect();

        $mitras = $topMitrasBase->map(function ($m) use ($d, $daily_cap, $weekly_cap, $monthly_cap, $dailyCounts, $weeklyCounts, $monthlyCounts, $avgDays) {
            $name = $m->nama_mitra;
            $daily = $dailyCounts[$name] ?? 0;
            $weekly = $weeklyCounts[$name] ?? 0;
            $monthly = $monthlyCounts[$name] ?? 0;
            $avgDaysVal = $avgDays[$name] ?? null;
            return [
                'name'        => $name,
                'total'       => $m->total,
                'daily'       => $daily,
                'weekly'      => $weekly,
                'monthly'     => $monthly,
                'daily_cap'   => $daily_cap,
                'weekly_cap'  => $weekly_cap,
                'monthly_cap' => $monthly_cap,
                'avg_time'    => $avgDaysVal ? round($avgDaysVal) . ' hari' : 'N/A',
            ];
        });

        return response()->json($mitras->values());
    }
}

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
            
            // Return JSON for AJAX requests
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Laporan harian berhasil dikirim ke Telegram!']);
            }
            
            return back()->with('success', 'Laporan harian berhasil dikirim ke Telegram!');
        } catch (\Exception $e) {
            \Log::error('Gagal kirim laporan harian Telegram via UI: ' . $e->getMessage());
            
            // Return JSON for AJAX requests
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengirim laporan Telegram. Cek logs.'], 500);
            }
            
            return back()->with('error', 'Gagal mengirim laporan Telegram. Cek logs.');
        }
    }

    public function dashboard()
    {
        // --- 1. STATS CARDS ---

        // Total Deployment (This Month)
        $totalDeployment = EbisManualInput::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Total Deployment (Last Month) - for comparison
        $lastMonthDeployment = EbisManualInput::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // Calculate Trend (Simple % change)
        $trendPercentage = 0;
        if ($lastMonthDeployment > 0) {
            $trendPercentage = (($totalDeployment - $lastMonthDeployment) / $lastMonthDeployment) * 100;
        }

        // Success Rate (All Time)
        $totalAll = EbisManualInput::count();
        $totalSuccess = EbisManualInput::whereHas('planning', function ($q) {
            $q->where('status_order', 'Success');
        })->count();
        $successRate = $totalAll > 0 ? ($totalSuccess / $totalAll) * 100 : 0;

        // Total On Process (Active but not valid pending or success)
        // Based on status-badge: progress, survey, inisiasi, validasi, drm, matdev, instalasi
        $totalOnProcess = EbisManualInput::whereHas('planning', function ($q) {
            $q->where(function($query) {
                $query->where('status_order', 'LIKE', '%Progress%')
                      ->orWhere('status_order', 'LIKE', '%Survey%')
                      ->orWhere('status_order', 'LIKE', '%Inisiasi%')
                      ->orWhere('status_order', 'LIKE', '%Validasi%')
                      ->orWhere('status_order', 'LIKE', '%Drm%')
                      ->orWhere('status_order', 'LIKE', '%Matdev%')
                      ->orWhere('status_order', 'LIKE', '%Instalasi%');
            });
        })->count();

        // Pending Review (Status = Pending / Wait)
        // Using 'Pending' or 'Wait'
        $pendingReview = EbisManualInput::whereHas('planning', function ($q) {
            $q->where(function($query) {
                $query->where('status_order', 'LIKE', '%Pending%')
                      ->orWhere('status_order', 'LIKE', '%Wait%');
            });
        })->count();

        // Issues Reported (Status = Kendala or Gagal or Cancel)
        $issuesReported = EbisManualInput::whereHas('planning', function ($q) {
            $q->whereIn('status_order', ['Kendala', 'Gagal', 'Cancel']);
        })->count();


        // D. Failure Rate
        $totalFailed = EbisManualInput::whereHas('planning', function ($q) {
             $q->whereIn('status_order', ['Gagal', 'Cancel']);
        })->count();
        $failureRate = $totalAll > 0 ? ($totalFailed / $totalAll) * 100 : 0;


        // --- 2. CHARTS DATA ---

        // Chart 1: Deployment Trend (Last 7 Days)
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();
        $trendData = EbisManualInput::select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', $sevenDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Prepare chart labels (Mon, Tue, etc.) and values
        $trendLabels = [];
        $trendValues = [];
        
        // Fill in missing days with 0
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayLabel = Carbon::now()->subDays($i)->locale('id')->shortDayName . ' ' . Carbon::now()->subDays($i)->format('d/m');
            
            $record = $trendData->firstWhere('date', $date);
            
            $trendLabels[] = $dayLabel;
            $trendValues[] = $record ? $record->total : 0;
        }

        // Chart 2: Status Distribution
        // We need to join with planning to group by status_order
        $statusDistRaw = EbisManualInput::select('ebis_planning_orders.status_order as status_label', DB::raw('count(*) as total'))
            ->join('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->groupBy('status_label')
            ->pluck('total', 'status_label');

        // Aggregate 'On Process' statuses
        $onProcessCount = 0;
        $onProcessKeywords = ['Progress', 'Survey', 'Inisiasi', 'Validasi', 'Drm', 'Matdev', 'Instalasi'];
        
        foreach ($statusDistRaw as $label => $count) {
            foreach ($onProcessKeywords as $keyword) {
                if (stripos($label, $keyword) !== false) {
                    $onProcessCount += $count;
                    break; // Stop checking other keywords for this label
                }
            }
        }

        $statusDist = [
            'Success' => $statusDistRaw['Success'] ?? 0,
            'On Process' => $onProcessCount,
            'Pending' => $statusDistRaw['Pending'] ?? 0,
            'Issues' => ($statusDistRaw['Kendala'] ?? 0) + ($statusDistRaw['Gagal'] ?? 0) + ($statusDistRaw['Cancel'] ?? 0)
        ];

        
        // --- 3. LIVE TABLE (Latest 5) ---
        $recentDeployments = EbisManualInput::with('planning')->latest()->take(5)->get();


        // --- 4. WAITING USERS ---
        $waitingUsers = User::where('role', 'waiting')->take(5)->get();


        // --- 5. TOP PARTNER PERFORMANCE (format for widget) ---
        $today = Carbon::today();
        $daily_cap = 3; $weekly_cap = 15; $monthly_cap = 60;
        $topMitras = EbisManualInput::select('nama_mitra', DB::raw('count(*) as total'))
            ->whereNotNull('nama_mitra')->where('nama_mitra', '!=', '')
            ->groupBy('nama_mitra')->orderByDesc('total')->limit(3)->get()
            ->map(function ($m) use ($today, $daily_cap, $weekly_cap, $monthly_cap) {
                $name = $m->nama_mitra;
                $daily   = EbisManualInput::where('nama_mitra', $name)->whereDate('created_at', $today)->count();
                $weekly  = EbisManualInput::where('nama_mitra', $name)->whereBetween('created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])->count();
                $monthly = EbisManualInput::where('nama_mitra', $name)->whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->count();
                $avgDays = EbisManualInput::where('nama_mitra', $name)->whereNotNull('tanggal_update_progres')->selectRaw('AVG(DATEDIFF(tanggal_update_progres, created_at)) as avg_days')->value('avg_days');
                return ['name' => $name, 'total' => $m->total, 'daily' => $daily, 'weekly' => $weekly, 'monthly' => $monthly, 'daily_cap' => $daily_cap, 'weekly_cap' => $weekly_cap, 'monthly_cap' => $monthly_cap, 'avg_time' => $avgDays ? round($avgDays) . ' hari' : 'N/A'];
            });
        // --- 6. LIVE PROGRESS LOGS (Live Tracking) ---
        $liveTracking = EbisPlanningProgressLog::with(['user', 'planning.manualInput'])
            ->latest()
            ->take(10)
            ->get();

        // --- 7. OVERDUE COMMITMENTS ---
        $today = Carbon::now()->startOfDay();
        $overdueCommitments = EbisManualInput::with('planning')
            ->whereHas('planning', function ($q) {
                $q->whereNotIn('status_order', ['Success', 'Gagal', 'Cancel']);
            })
            ->whereNotIn('progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
            ->get()
            ->filter(function ($item) use ($today) {
                if (!empty($item->data['commitment_date'])) {
                    try {
                        return Carbon::parse($item->data['commitment_date'])->startOfDay()->lt($today);
                    } catch (\Exception $e) {
                        return false;
                    }
                }
                return false;
            })
            ->map(function ($item) {
                // Ambil nama user yang set commitment dari tabel users
                $userId = $item->data['commitment_updated_by'] ?? null;
                $userName = $userId
                    ? (\App\Models\User::find($userId)?->name ?? 'Unknown')
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

        // --- FILTER OPTIONS FOR TREND CHART ---
        $trendFilterOptions = [
            'datels' => EbisManualInput::whereNotNull('datel')->where('datel','!=','')->distinct()->orderBy('datel')->pluck('datel'),
            'stos'   => EbisManualInput::whereNotNull('sto')->where('sto','!=','')->distinct()->orderBy('sto')->pluck('sto'),
            'mitras' => EbisManualInput::whereNotNull('nama_mitra')->where('nama_mitra','!=','')->distinct()->orderBy('nama_mitra')->pluck('nama_mitra'),
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
        // ...

        // B. Aging Analysis (Distribution of active deployments)
        // We need raw days diff for active orders
        $activeOrders = EbisManualInput::whereHas('planning', function ($q) {
                $q->whereNotIn('status_order', ['Success', 'Gagal', 'Cancel']);
            })
            ->whereNotNull('created_at') // Added safety
            ->select('created_at')
            ->get();

        $aging = [
            '0-3' => 0,
            '4-7' => 0,
            '8-14' => 0,
            '>14' => 0
        ];

        foreach ($activeOrders as $order) {
            if (!$order->created_at) continue; // Safety check
            $days = $order->created_at->diffInDays($now);
            if ($days <= 3) $aging['0-3']++;
            elseif ($days <= 7) $aging['4-7']++;
            elseif ($days <= 14) $aging['8-14']++;
            else $aging['>14']++;
        }

        // C. KPI Progress (Monthly)
        $kpiTarget = 100; // Hardcoded target
        $kpiRealization = $totalDeployment; // Assuming total deployment this month is the realization
        // Or strictly 'Success' this month? Usually deployment target involves successes. 
        // Let's use Total Deployment for now as "Production", or Success if requested strictly.
        // User asked "target bulanan vs realisasi". Let's use Success for a stricter KPI.
        $monthlySuccess = EbisManualInput::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereHas('planning', function ($q) {
                $q->where('status_order', 'Success');
            })->count();
        
        $kpiPercentage = $kpiTarget > 0 ? ($monthlySuccess / $kpiTarget) * 100 : 0;


        // D. Failure Rate
        $totalFailed = EbisManualInput::whereHas('planning', function ($q) {
             $q->whereIn('status_order', ['Gagal', 'Cancel']);
        })->count();
        $failureRate = $totalAll > 0 ? ($totalFailed / $totalAll) * 100 : 0;


        // --- 4. DETAILS ---

        // Recent Deployments
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

        // Top Partners
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

        // Status Dist (Simplified for JSON)
        $statusDist = [
            'Success' => $totalSuccess,
            'On Process' => $totalOnProcess,
            'Pending' => $pendingReview,
            'Issues' => $issuesReported
        ];

        return response()->json([
            // Basic
            'totalDeployment' => number_format($totalDeployment),
            'trendPercentage' => number_format($trendPercentage, 1),
            'isTrendPositive' => $trendPercentage >= 0,
            'successRate' => number_format($successRate, 1),
            'totalOnProcess' => number_format($totalOnProcess),
            'pendingReview' => number_format($pendingReview),
            'issuesReported' => number_format($issuesReported),
            // Enterprise
            'overSLACount' => $overSLACount,
            'aging' => $aging,
            'kpi' => [
                'target' => $kpiTarget,
                'realization' => $monthlySuccess,
                'percentage' => round($kpiPercentage, 1)
            ],
            'failureRate' => round($failureRate, 1),
            // Lists
            'recentDeployments' => $recentDeployments,
            'statusDist' => array_values($statusDist),
            'topMitras' => $topMitras
        ]);
    }
    public function getRealtimeStats()
    {
        // 1. Basic Counts
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

        $totalAll = EbisManualInput::count();
        $totalSuccess = EbisManualInput::whereHas('planning', function ($q) {
            $q->where('status_order', 'Success');
        })->count();
        $successRate = $totalAll > 0 ? ($totalSuccess / $totalAll) * 100 : 0;

        $totalOnProcess = EbisManualInput::whereHas('planning', function ($q) {
            $q->where(function ($query) {
                $query->where('status_order', 'LIKE', '%Progress%')
                    ->orWhere('status_order', 'LIKE', '%Survey%')
                    ->orWhere('status_order', 'LIKE', '%Inisiasi%')
                    ->orWhere('status_order', 'LIKE', '%Validasi%')
                    ->orWhere('status_order', 'LIKE', '%Drm%')
                    ->orWhere('status_order', 'LIKE', '%Matdev%')
                    ->orWhere('status_order', 'LIKE', '%Instalasi%');
            });
        })->count();

        $pendingReview = EbisManualInput::whereHas('planning', function ($q) {
            $q->where(function ($query) {
                $query->where('status_order', 'LIKE', '%Pending%')
                    ->orWhere('status_order', 'LIKE', '%Wait%');
            });
        })->count();

        $issuesReported = EbisManualInput::whereHas('planning', function ($q) {
            $q->whereIn('status_order', ['Kendala', 'Gagal', 'Cancel']);
        })->count();

        // 2. Recent Deployments (Live Table)
        $recentDeployments = EbisManualInput::with('planning')
            ->latest()
            ->take(10) // Show last 10
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

        // 3. Status Distribution (Chart)
        $statusDistRaw = EbisManualInput::select('ebis_planning_orders.status_order as status_label', DB::raw('count(*) as total'))
            ->join('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->groupBy('status_label')
            ->pluck('total', 'status_label');

        // Aggregate 'On Process' statuses
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
            'On Process' => $onProcessCount, // Added this
            'Pending' => $statusDistRaw['Pending'] ?? 0,
            'Issues' => ($statusDistRaw['Kendala'] ?? 0) + ($statusDistRaw['Gagal'] ?? 0) + ($statusDistRaw['Cancel'] ?? 0)
        ];

        // 4. Waiting Users (Optional, if we want to update this too, but for now user focused on partners)
        // ...

        // 5. Top Partner Performance
        $topMitras = EbisManualInput::select('nama_mitra', DB::raw('count(*) as total_jobs'))
            ->whereNotNull('nama_mitra')
            ->where('nama_mitra', '!=', '')
            ->groupBy('nama_mitra')
            ->orderByDesc('total_jobs')
            ->take(3)
            ->get()
            ->map(function($mitra) {
                $successCount = EbisManualInput::where('nama_mitra', $mitra->nama_mitra)
                    ->whereHas('planning', function ($q) {
                        $q->where('status_order', 'LIKE', '%Success%');
                    })
                    ->count();
                
                $rate = $mitra->total_jobs > 0 ? ($successCount / $mitra->total_jobs) * 100 : 0;
                
                return [
                    'name' => $mitra->nama_mitra,
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
        $filter = $request->get('filter', 'daily'); // daily, weekly, monthly
        $datel  = $request->get('datel');
        $sto    = $request->get('sto');
        $mitra  = $request->get('mitra');

        $labels = [];
        $values = [];

        // Helper: build a base query with optional filters
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

    /**
     * Progress Overview Dashboard — accessible to all deployment roles (non-admin).
     */
    public function progressOverview(Request $request)
    {
        // --- Filter parameters ---
        $filterStoArr   = array_filter((array) $request->get('sto', []));
        $filterDatelArr = array_filter((array) $request->get('datel', []));
        $filterMitraArr = array_filter((array) $request->get('mitra', []));

        $progA = $request->get('prog_a');
        $progB = $request->get('prog_b');

        // Keep backward-compat single values for old links
        $filterSto   = count($filterStoArr) === 1 ? $filterStoArr[0] : null;
        $filterDatel = count($filterDatelArr) === 1 ? $filterDatelArr[0] : null;
        $filterMitra = count($filterMitraArr) === 1 ? $filterMitraArr[0] : null;

        // Helper: build base query with optional filters
        $baseQuery = function () use ($filterStoArr, $filterDatelArr, $filterMitraArr) {
            $q = EbisManualInput::query();
            if (!empty($filterStoArr))   $q->whereIn('ebis_manual_inputs.sto', $filterStoArr);
            if (!empty($filterDatelArr)) $q->whereIn('ebis_manual_inputs.datel', $filterDatelArr);
            if (!empty($filterMitraArr)) $q->whereIn('ebis_manual_inputs.nama_mitra', $filterMitraArr);
            return $q;
        };

        // --- Filter option lists (unfiltered, for dropdowns) ---
        $stoList   = EbisManualInput::whereNotNull('sto')->where('sto', '!=', '')->distinct()->orderBy('sto')->pluck('sto');
        $datelList = EbisManualInput::whereNotNull('datel')->where('datel', '!=', '')->distinct()->orderBy('datel')->pluck('datel');
        $mitraList = EbisManualInput::whereNotNull('nama_mitra')->where('nama_mitra', '!=', '')->distinct()->orderBy('nama_mitra')->pluck('nama_mitra');

        // Define the ordered progress stages
        $stages = [
            'ON DESK', 'SURVEY', 'PERIJINAN', 'DRM', 'APPROVED BY EBIS',
            'MATDEV', 'INSTALASI', 'SELESAI FISIK', 'GOLIVE',
            'PS', 'KENDALA', 'UJI TERIMA', 'REKON',
        ];

        // Count deployments per Datel for stacked calculation (filtered)
        $datels = $baseQuery()
            ->whereNotNull('datel')
            ->where('datel', '!=', '')
            ->distinct()
            ->pluck('datel')
            ->map(fn($d) => strtoupper($d))
            ->toArray();

        // Get total per Datel and per Progress Stage
        $rawStackedCounts = $baseQuery()
            ->select('datel', 'progres', DB::raw('count(*) as total'))
            ->whereNotNull('datel')->where('datel', '!=', '')
            ->whereNotNull('progres')->where('progres', '!=', '')
            ->groupBy('datel', 'progres')
            ->get();

        // Prepare labels (Datels) and datasets (Progress Stages)
        $datelLabels = array_values(array_unique($datels));
        $stackedData = [];
        
        foreach ($stages as $stage) {
            $stackedData[$stage] = [];
            foreach ($datelLabels as $datel) {
                // Find count for this specific datel and stage
                $match = $rawStackedCounts->first(function ($item) use ($datel, $stage) {
                    return strtoupper($item->datel) === $datel && strtoupper($item->progres) === $stage;
                });
                $stackedData[$stage][] = $match ? $match->total : 0;
            }
        }

        // Summary stats (filtered)
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
            
        // ON TRACK = Seluruh deployment dikurangi deployment yang secara global Overdue
        $totalOnTrack   = $totalAll - $totalOverdue;
        if ($totalOnTrack < 0) $totalOnTrack = 0;

        // Top datel (stage with most deployments)
        $topProgress = null;
        $topProgressCount = 0;
        
        // Calculate total per datel to find the top one
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

        // Recent progress updates (last 10, filtered)
        $recentUpdates = $baseQuery()
            ->whereNotNull('progres')
            ->where('progres', '!=', '')
            ->orderByDesc('updated_at')
            ->take(10)
            ->get(['star_click_id', 'nama_customer', 'progres', 'datel', 'sto', 'updated_at']);

        // Group iHLD Status Order by Datel and Status Order
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

        $finishedOrders = (clone $baseQuery())
            ->whereIn('ebis_manual_inputs.progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
            ->whereNotNull('ebis_manual_inputs.nama_mitra')
            ->where('ebis_manual_inputs.nama_mitra', '!=', '')
            ->with(['planning' => function($q) {
                $q->with(['logs' => function($q2) {
                    $q2->whereIn('progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
                       ->orderBy('created_at', 'asc');
                }]);
            }])
            ->get(['ebis_manual_inputs.star_click_id', 'ebis_manual_inputs.nama_mitra', 'ebis_manual_inputs.created_at', 'ebis_manual_inputs.tanggal_update_progres']);

        $mitraStats = [];
        foreach ($finishedOrders as $order) {
            $firstLog = $order->planning?->logs->first();
            $finishTime = null;

            if ($firstLog) {
                $finishTime = $firstLog->created_at;
            } elseif ($order->tanggal_update_progres) {
                $finishTime = \Carbon\Carbon::parse($order->tanggal_update_progres);
            }

            if ($finishTime && $order->created_at) {
                $minutes = abs($order->created_at->diffInMinutes($finishTime, false));
                $mitra = $order->nama_mitra;
                if (!isset($mitraStats[$mitra])) {
                    $mitraStats[$mitra] = ['total_minutes' => 0, 'count' => 0];
                }
                $mitraStats[$mitra]['total_minutes'] += $minutes;
                $mitraStats[$mitra]['count']++;
            }
        }

        $mitraAvgArray = [];
        foreach ($mitraStats as $mitra => $stat) {
            if ($stat['count'] > 0) {
                $avgMinutes = $stat['total_minutes'] / $stat['count'];
                $avgDaysRaw = $avgMinutes / 1440;
                
                $days = floor($avgMinutes / 1440);
                $hours = floor(($avgMinutes % 1440) / 60);
                
                $labelStr = "{$days} Hari";
                if ($hours > 0) $labelStr .= " {$hours} Jam";

                // Calculate total days for display
                $totalDays = floor($stat['total_minutes'] / 1440);
                $totalHours = floor(($stat['total_minutes'] % 1440) / 60);
                $totalLabel = "{$totalDays} Hari";
                if ($totalHours > 0) $totalLabel .= " {$totalHours} Jam";

                $mitraAvgArray[] = [
                    'mitra' => $mitra,
                    'avg_raw' => round($avgDaysRaw, 2),
                    'avg_label' => $labelStr,
                    'count' => $stat['count'],
                    'total_minutes' => $stat['total_minutes'],
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

        // Check if any filter is active
        $hasFilter = !empty($filterStoArr) || !empty($filterDatelArr) || !empty($filterMitraArr) || ($progA && $progB);

        return view('deployment.progress-overview', compact(
            'datelLabels', 'stackedData', 'totalAll', 'totalOverdue', 'totalSelesai', 'totalOnTrack',
            'recentUpdates', 'stoList', 'datelList', 'mitraList',
            'filterSto', 'filterDatel', 'filterMitra',
            'filterStoArr', 'filterDatelArr', 'filterMitraArr', 'hasFilter',
            'topProgress', 'topProgressCount',
            'ihldStatuses', 'ihldStackedData',
            'progA', 'progB', 'avgDurationAB', 'mitraAvgLabels', 'mitraAvgValues', 'mitraAvgTextLabels', 'mitraAvgArray', 'stages'
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

        // Get all orders for the month
        $orders = EbisManualInput::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->select('created_at', 'nama_mitra')
            ->get();

        // Build a lookup: date => [mitra => count]
        $ordersByDate = [];
        foreach ($orders as $order) {
            $d = Carbon::parse($order->created_at)->format('Y-m-d');
            $mitra = $order->nama_mitra ?? 'Tanpa Mitra';
            if (!isset($ordersByDate[$d])) $ordersByDate[$d] = [];
            if (!isset($ordersByDate[$d][$mitra])) $ordersByDate[$d][$mitra] = 0;
            $ordersByDate[$d][$mitra]++;
        }

        // Build the calendar grid (Mon-Sun, with padding)
        $startPad = ($firstDay->dayOfWeekIso - 1); // Mon=0 pad
        $endPad   = (7 - $lastDay->dayOfWeekIso) % 7;

        $days = [];

        // Leading empty days
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

        // Days in month
        for ($i = 0; $i < $firstDay->daysInMonth; $i++) {
            $d = $firstDay->copy()->addDays($i);
            $key = $d->format('Y-m-d');
            $details = [];
            $total = 0;
            if (isset($ordersByDate[$key])) {
                foreach ($ordersByDate[$key] as $mitra => $cnt) {
                    $details[] = ['mitra' => $mitra, 'count' => $cnt];
                    $total += $cnt;
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

        // Trailing empty days
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

        $maxOrders = count($orders) > 0 ? max(array_map(fn($d) => $d['count'], $days)) : 10;
        $globalCap = max($maxOrders, 10);

        return response()->json([
            'week_headers' => $days,
            'global_cap'   => $globalCap,
        ]);
    }

    public function getTopMitras(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $d    = Carbon::parse($date);

        $daily_cap   = 3;
        $weekly_cap  = 15;
        $monthly_cap = 60;

        $mitras = EbisManualInput::select('nama_mitra', DB::raw('count(*) as total'))
            ->whereNotNull('nama_mitra')
            ->groupBy('nama_mitra')
            ->orderByDesc('total')
            ->limit(3)
            ->get()
            ->map(function ($m) use ($d, $daily_cap, $weekly_cap, $monthly_cap) {
                $name = $m->nama_mitra;

                $daily = EbisManualInput::where('nama_mitra', $name)
                    ->whereDate('created_at', $d)->count();

                $weekly = EbisManualInput::where('nama_mitra', $name)
                    ->whereBetween('created_at', [$d->copy()->startOfWeek(), $d->copy()->endOfWeek()])
                    ->count();

                $monthly = EbisManualInput::where('nama_mitra', $name)
                    ->whereMonth('created_at', $d->month)
                    ->whereYear('created_at', $d->year)
                    ->count();

                // Average cycle time: created_at to tanggal_update_progres
                $avgDays = EbisManualInput::where('nama_mitra', $name)
                    ->whereNotNull('tanggal_update_progres')
                    ->selectRaw('AVG(DATEDIFF(tanggal_update_progres, created_at)) as avg_days')
                    ->value('avg_days');

                return [
                    'name'        => $name,
                    'total'       => $m->total,
                    'daily'       => $daily,
                    'weekly'      => $weekly,
                    'monthly'     => $monthly,
                    'daily_cap'   => $daily_cap,
                    'weekly_cap'  => $weekly_cap,
                    'monthly_cap' => $monthly_cap,
                    'avg_time'    => $avgDays ? round($avgDays) . ' hari' : 'N/A',
                ];
            });

        return response()->json($mitras->values());
    }
}

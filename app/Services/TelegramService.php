<?php

namespace App\Services;

use App\Models\EbisManualInput;
use App\Models\EbisPlanningProgressLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token', '');
        $this->chatId   = config('services.telegram.chat_id', '');
    }

    public function sendMessage(string $text, ?string $chatId = null): bool
    {
        if (empty($this->botToken) || empty($chatId ?? $this->chatId)) {
            Log::warning('Telegram: bot_token atau chat_id belum diset.');
            return false;
        }

        
        dispatch(new \App\Jobs\SendTelegramNotification($text, $chatId ?? $this->chatId));

        
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $artisan = base_path('artisan');
            pclose(popen("start /B php \"$artisan\" queue:work --once > NUL 2>&1", "r"));
        }

        return true;
    }

    
    public function notifyNewOrder(EbisManualInput $order): void
    {
        $text  = "📢 <b>ORDER BARU DIBUAT</b>\n";
        $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        $text .= "📌 <b>Star Click ID:</b> {$order->star_click_id}\n";
        $text .= "👤 <b>Customer:</b> {$order->nama_customer}\n";
        $text .= "🏢 <b>STO:</b> " . strtoupper($order->sto) . " · <b>Datel:</b> {$order->datel}\n";
        $text .= "🔧 <b>Mitra:</b> {$order->nama_mitra}\n";

        if ($order->alamat_pelanggan) {
            $text .= "📍 <b>Alamat:</b> {$order->alamat_pelanggan}\n";
        }
        if ($order->telepon_pelanggan) {
            $text .= "📞 <b>Telepon:</b> {$order->telepon_pelanggan}\n";
        }

        $text .= "\n🕐 <b>Dibuat:</b> " . now()->format('d M Y H:i') . " WIB";

        $this->sendMessage($text);
    }

    
    public function notifyProgressUpdate(EbisManualInput $order, string $progres, ?string $keterangan = null): void
    {
        $text  = "📢 <b>UPDATE PROGRESS DEPLOYMENT</b>\n";
        $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        $text .= "📌 <b>Star Click ID:</b> {$order->star_click_id}\n";
        $text .= "👤 <b>Customer:</b> {$order->nama_customer}\n";
        $text .= "🏢 <b>STO:</b> " . strtoupper($order->sto) . " · <b>Datel:</b> {$order->datel}\n";
        $text .= "🔧 <b>Mitra:</b> {$order->nama_mitra}\n\n";

        $text .= "📊 <b>Progress:</b> {$progres}\n";

        
        $planning = $order->planning;
        if ($planning) {
            $logs = $planning->logs()->with('user')->orderBy('created_at', 'asc')->get();
            if ($logs->isNotEmpty()) {
                $text .= "\n📅 <b>Riwayat Progress:</b>\n";
                foreach ($logs as $i => $log) {
                    $no = $i + 1;
                    $date = $log->created_at->format('d M Y');
                    $user = $log->user->name ?? 'System';
                    $isLast = ($i === $logs->count() - 1);
                    $marker = $isLast ? ' ← Sekarang' : '';
                    $text .= "{$no}. {$log->progres} — {$date} ({$user}){$marker}\n";
                }
            }
        }

        $text .= "\n🕐 <b>Update:</b> " . now()->format('d M Y H:i') . " WIB";
        $text .= "\n👷 <b>Oleh:</b> " . (auth()->user()->name ?? 'Unknown');

        $this->sendMessage($text);
    }

    
    public function sendDailyReport(): void
    {
        $dateStr = now()->format('d M Y');

        $text  = "📢 <b>[LAPORAN HARIAN OTOMATIS]</b>\n";
        $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        $text .= "🌅 <b>SEMANGAT PAGI!</b> ☀️\n\n";
        $text .= "Berikut kami sampaikan Progress Order Hari ini\n";
        $text .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $text .= "📊 <b>FORMAT DATA</b>\n\n";
        $text .= "Kategori Umur | Wilayah Telkom | Nomor NDE JT | Starclick ID/NCX | Nama Pelanggan | Nama Mitra | Status Order | Status Tomps | Status Alokasi Alpro\n\n";
        $text .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

        
        $statuses = [
            'NEW ORDER' => ['NEW ORDER', 'NEW'],
            'ON DESK' => ['ON DESK'],
            'SURVEY' => ['SURVEY'],
            'PERIJINAN' => ['PERIJINAN', 'IJIN'],
            'DRM' => ['DRM'],
            'APPROVED BY EBIS' => ['APPROVED BY EBIS', 'APPROVED'],
            'MATDEV' => ['MATDEV'],
            'INSTALASI' => ['INSTALASI'],
            'SELESAI FISIK' => ['SELESAI FISIK', 'SELESAI'],
            'GO LIVE' => ['GO LIVE', 'GOLIVE'],
            'PS' => ['PS'],
            'KENDALA' => ['KENDALA', 'GAGAL', 'CANCEL'],
            'UJI TERIMA' => ['UJI TERIMA'],
            'REKON' => ['REKON'],
        ];

        $statusEmojis = [
            'NEW ORDER' => '🆕',
            'ON DESK' => '🆕',
            'SURVEY' => '📍',
            'PERIJINAN' => '📝',
            'DRM' => '⚙️',
            'APPROVED BY EBIS' => '⏳',
            'MATDEV' => '🏗️',
            'INSTALASI' => '🔌',
            'SELESAI FISIK' => '🏁',
            'GO LIVE' => '🚀',
            'PS' => '📦',
            'KENDALA' => '⚠️',
            'UJI TERIMA' => '✅',
            'REKON' => '📑',
        ];

        
        $orders = \App\Models\EbisManualInput::with(['planning'])
            ->whereNotIn('progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON', 'GAGAL', 'CANCEL'])
            ->orderBy('created_at', 'desc')
            ->get();

        
        $completedToday = \App\Models\EbisManualInput::with(['planning'])
            ->whereIn('progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
            ->whereDate('updated_at', now()->format('Y-m-d'))
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalOrders = $orders->count();
        $totalCompletedToday = $completedToday->count();

        $text .= "<b>📈 SUMMARY</b>\n";
        $text .= "━━━━━━━━━━━━━━━━━━━━\n";
        $text .= "Total Order Aktif: <b>{$totalOrders}</b>\n";
        $text .= "Selesai Hari Ini: <b>{$totalCompletedToday}</b>\n";
        $text .= "Tanggal Report: <b>{$dateStr}</b>\n\n";
        $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";

        foreach ($statuses as $statusLabel => $statusKeywords) {
            $text .= "<b>{$statusEmojis[$statusLabel]} {$statusLabel}</b>\n";
            $text .= "────────────────────────────\n\n";

            $filteredOrders = $orders->filter(function($order) use ($statusKeywords) {
                foreach ($statusKeywords as $keyword) {
                    if (stripos($order->progres, $keyword) !== false) {
                        return true;
                    }
                }
                return false;
            });

            if ($filteredOrders->isEmpty()) {
                $text .= "(Belum ada data)\n\n";
            } else {
                foreach ($filteredOrders as $order) {
                    
                    $daysSinceCreated = round($order->created_at->diffInDays(now()));
                    if ($daysSinceCreated <= 6) {
                        $ageCategory = '≤6HR';
                    } elseif ($daysSinceCreated <= 14) {
                        $ageCategory = '>6HR ≤14HR';
                    } else {
                        $ageCategory = '>14HR';
                    }

                    $nde = $order->nde_jt ?? '-';
                    $starclick = $order->star_click_id ?? '-';
                    $customer = $order->nama_customer ?? '-';
                    $mitra = $order->nama_mitra ?? '-';
                    $statusOrder = $order->progres ?? '-';
                    $datel = strtoupper($order->datel ?? '-');

                    
                    $tompsStatus = '-';
                    $alproStatus = 'Waiting for Allocation';
                    if ($order->planning) {
                        $tompsStatus = $order->planning->status_tomps ?? '-';
                        $alproStatus = $order->planning->status_alokasi_alpro ?? 'Waiting for Allocation';
                    }

                    
                    $text .= "{$ageCategory} | {$datel} | {$nde} | {$starclick} | {$customer} | {$mitra} | {$statusOrder} | {$tompsStatus} | {$alproStatus}\n\n";
                }
            }
        }

        
        if ($completedToday->isNotEmpty()) {
            $text .= "<b>🚀 SELESAI HARI INI</b>\n";
            $text .= "────────────────────────────\n\n";

            foreach ($completedToday as $order) {
                
                $daysToComplete = round($order->created_at->diffInDays($order->updated_at));
                $ageCategory = $daysToComplete . ' HR';

                $nde = $order->nde_jt ?? '-';
                $starclick = $order->star_click_id ?? '-';
                $customer = $order->nama_customer ?? '-';
                $mitra = $order->nama_mitra ?? '-';
                $statusOrder = $order->progres ?? '-';
                $datel = strtoupper($order->datel ?? '-');

                
                $tompsStatus = '-';
                $alproStatus = 'Waiting for Allocation';
                if ($order->planning) {
                    $tompsStatus = $order->planning->status_tomps ?? '-';
                    $alproStatus = $order->planning->status_alokasi_alpro ?? 'Waiting for Allocation';
                }

                $text .= "{$ageCategory} | {$datel} | {$nde} | {$starclick} | {$customer} | {$mitra} | {$statusOrder} | {$tompsStatus} | {$alproStatus}\n\n";
            }
        }

        $text .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $text .= "<i>Laporan di-generate otomatis oleh sistem pada {$dateStr} pukul " . now()->format('H:i') . " WIB</i>";

        $this->sendMessage($text);
    }
}

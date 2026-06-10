<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendTelegramNotification implements ShouldQueue
{
    use Queueable;

    protected string $text;
    protected string $chatId;

    
    public function __construct(string $text, string $chatId)
    {
        $this->text = $text;
        $this->chatId = $chatId;
    }

    
    public function handle(): void
    {
        $botToken = config('services.telegram.bot_token', '');

        if (empty($botToken) || empty($this->chatId)) {
            \Illuminate\Support\Facades\Log::warning('Telegram Job: bot_token atau chat_id belum diset.');
            return;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id'    => $this->chatId,
                'text'       => $this->text,
                'parse_mode' => 'HTML',
            ]);

            if ($response->failed()) {
                \Illuminate\Support\Facades\Log::error('Telegram Job sendMessage gagal', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Telegram Job sendMessage exception', ['error' => $e->getMessage()]);
        }
    }
}

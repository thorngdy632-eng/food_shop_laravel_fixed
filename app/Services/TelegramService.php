<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    public function sendOrderNotification($order, $cartItems): void
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            Log::warning('Telegram credentials not configured');
            return;
        }

        $items = $cartItems->map(fn ($item) =>
            "• {$item['name']} × {$item['quantity']} = \${$item['price']}"
        )->implode("\n");

        $message = "🛒 *ការបញ្ជាទិញថ្មី #{$order->id}*\n"
            . "———————————————————————\n"
            . "*អតិថិជន:* {$order->name}\n"
            . "*ទូរស័ព្ទ:* {$order->phone}\n"
            . "*អាសយដ្ឋាន:* {$order->address}\n"
            . "*បង់ប្រាក់តាម:* {$order->payment_method}\n"
            . "———————————————————————\n"
            . "*ទំនិញ:*\n{$items}\n"
            . "———————————————————————\n"
            . "*សរុប:* \${$order->total_price}";

        $this->sendMessage($message);
    }

    protected function sendMessage(string $message): void
    {
        $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        if (! $response->successful()) {
            Log::warning('Telegram API error: ' . $response->body());
        }
    }
}

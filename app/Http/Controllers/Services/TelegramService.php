<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private string $botToken;
    private string $chatId;

    public function __construct()
    {
        // FIX: cast to string so empty config values don't cause type errors
        $this->botToken = (string) config('services.telegram.bot_token', '');
        $this->chatId   = (string) config('services.telegram.chat_id', '');
    }

    /**
     * Send an order notification to your Telegram bot chat.
     */
    public function sendOrderNotification(Order $order, Collection $cartItems): bool
    {
        $itemLines = $cartItems->map(function ($item) {
            return sprintf(
                "  • %s x%d — \$%.2f",
                $item['name'],
                $item['quantity'],
                $item['price'] * $item['quantity']
            );
        })->implode("\n");

        $paymentLabel = match ($order->payment_method) {
            'cash' => '💵 Cash on Delivery',
            'card' => '💳 Credit / Debit Card',
            'qr'   => '📱 QR Code / E-Wallet',
            default => ucfirst($order->payment_method),
        };

        // FIX: guard against null notes
        $notes = ! empty($order->notes) ? $order->notes : '—';

        $message = <<<MSG
🛒 *New Order Received!*

🆔 Order \#: `{$order->id}`
👤 Customer: {$order->name}
📞 Phone: {$order->phone}
📍 Address: {$order->address}
💰 Payment: {$paymentLabel}

🍽 *Items:*
{$itemLines}

💵 *Total: \${$order->total_price}*
📝 Notes: {$notes}

🕐 Time: {$order->created_at->format('d M Y, H:i')}
MSG;

        return $this->sendMessage($message);
    }

    /**
     * Send a raw message to the Telegram chat.
     */
    public function sendMessage(string $text): bool
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            Log::warning('Telegram bot token or chat ID not configured.');
            return false;
        }

        try {
            $response = Http::timeout(10)->post(
                "https://api.telegram.org/bot{$this->botToken}/sendMessage",
                [
                    'chat_id'    => $this->chatId,
                    'text'       => $text,
                    'parse_mode' => 'Markdown',
                ]
            );

            if (! $response->successful()) {
                Log::error('Telegram API error: ' . $response->body());
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Telegram send failed: ' . $e->getMessage());
            return false;
        }
    }
}

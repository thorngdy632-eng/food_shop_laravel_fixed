<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenCodeAiService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;
    protected int $timeout;

    public function __construct()
    {
        $this->apiKey  = config('services.opencode_ai.api_key');
        $this->baseUrl = config('services.opencode_ai.base_url', 'https://opencode.ai/zen/v1');
        $this->model   = config('services.opencode_ai.model', 'gpt-5.4-mini');
        $this->timeout = (int) config('services.opencode_ai.timeout', 30);
    }

    /**
     * Send a chat completion prompt to the OpenCode AI API.
     *
     * @param  string  $systemPrompt  System-level instruction
     * @param  string  $userPrompt    The user message
     * @param  array   $override      Optional overrides (model, temperature, max_tokens)
     * @return array{success: bool, data?: mixed, error?: string}
     */
    public function chat(string $systemPrompt, string $userPrompt, array $override = []): array
    {
        if (empty($this->apiKey)) {
            Log::warning('OpenCode AI API key not configured');
            return ['success' => false, 'error' => 'AI service is not configured.'];
        }

        $payload = [
            'model'       => $override['model'] ?? $this->model,
            'messages'    => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $userPrompt],
            ],
            'temperature' => $override['temperature'] ?? 0.7,
            'max_tokens'  => $override['max_tokens'] ?? 1024,
        ];

        try {
            $response = Http::timeout($this->timeout)
                ->withToken($this->apiKey)
                ->acceptJson()
                ->post("{$this->baseUrl}/chat/completions", $payload);

            if ($response->successful()) {
                $body = $response->json();

                $content = $body['choices'][0]['message']['content'] ?? null;

                if ($content === null) {
                    Log::warning('OpenCode AI: unexpected response structure', ['body' => $body]);
                    return ['success' => false, 'error' => 'Unexpected response from AI service.'];
                }

                return [
                    'success' => true,
                    'data'    => $content,
                    'usage'   => $body['usage'] ?? null,
                ];
            }

            $status = $response->status();
            $errorBody = $response->body();
            Log::error("OpenCode AI API error [{$status}]: {$errorBody}");

            $message = match (true) {
                $status === 401 => 'AI service authentication failed.',
                $status === 429 => 'AI service rate limit exceeded. Please try again later.',
                $status >= 500  => 'AI service is temporarily unavailable.',
                default         => 'AI request failed with status ' . $status,
            };

            return ['success' => false, 'error' => $message];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('OpenCode AI connection timeout: ' . $e->getMessage());
            return ['success' => false, 'error' => 'AI service connection timed out. Please try again.'];
        } catch (\Exception $e) {
            Log::error('OpenCode AI unexpected error: ' . $e->getMessage());
            return ['success' => false, 'error' => 'An unexpected error occurred while contacting AI service.'];
        }
    }

    // ─────────────────────────────────────────────────────────────
    //  Domain-specific helpers
    // ─────────────────────────────────────────────────────────────

    /**
     * Generate a smart description for a food item.
     */
    public function generateFoodDescription(string $name, string $category, float $price, ?string $keywords = null): array
    {
        $sysPrompt = <<<PROMPT
You are a professional Khmer food copywriter for an e-commerce shop called "THORNG DY'S SHOP".
Write a persuasive, mouth-watering food description in Khmer (2-3 sentences).
Keep it warm, authentic, and appetising. Do NOT include price or placeholders.
Output only the description — no prefix, no label, no quotation marks.
PROMPT;

        $userMsg = "Food: {$name}\nCategory: {$category}\nPrice: \${$price}";

        if ($keywords) {
            $userMsg .= "\nHighlight these aspects: {$keywords}";
        }

        return $this->chat($sysPrompt, $userMsg, ['temperature' => 0.8, 'max_tokens' => 300]);
    }

    /**
     * Analyse recent orders and return trends / insights.
     *
     * @param  array  $orders  Array of Order arrays (id, total_price, status, created_at, items)
     * @return array
     */
    public function analyseOrderTrends(array $orders): array
    {
        $summary = collect($orders)->map(fn ($o) => [
            'id'     => $o['id'],
            'total'  => $o['total_price'],
            'status' => $o['status'],
            'date'   => $o['created_at'],
            'items'  => collect($o['items'])->pluck('name')->implode(', '),
        ]);

        $sysPrompt = <<<PROMPT
You are a data analyst for "THORNG DY'S SHOP", a Khmer food e-commerce store.
Analyse the order data below and provide concise insights in Khmer.
Cover: popular items, revenue patterns, and any notable trends.
Keep it brief — 3-5 bullet points. Output only the analysis, no extra text.
PROMPT;

        return $this->chat($sysPrompt, $summary->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), [
            'temperature' => 0.3,
            'max_tokens'  => 600,
        ]);
    }

    /**
     * Generate a smart reply to a customer message or review.
     */
    public function smartCustomerReply(string $customerName, string $message, string $context = 'review'): array
    {
        $sysPrompt = match ($context) {
            'complaint' => <<<PROMPT
You are a polite customer-service representative for "THORNG DY'S SHOP".
Reply to the customer's complaint in Khmer. Apologise sincerely, acknowledge the issue,
and offer a helpful resolution. Be warm and professional.
PROMPT,
            'inquiry'   => <<<PROMPT
You are a helpful sales assistant for "THORNG DY'S SHOP".
Answer the customer's question in Khmer clearly and concisely.
Be friendly and encourage them to place an order.
PROMPT,
            default     => <<<PROMPT
You are a friendly brand representative for "THORNG DY'S SHOP".
Respond to the customer's message in Khmer with gratitude and warmth.
Keep it short and genuine.
PROMPT,
        };

        return $this->chat($sysPrompt, "Customer name: {$customerName}\nMessage: {$message}", [
            'temperature' => 0.7,
            'max_tokens'  => 400,
        ]);
    }
}

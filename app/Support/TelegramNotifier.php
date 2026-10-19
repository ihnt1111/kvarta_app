<?php

namespace App\Support;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotifier
{
    public function sendNewLead(Lead $lead): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            return;
        }

        $interestMap = [
            'order' => 'Разовый заказ',
            'subscription' => 'Подписка',
            'question' => 'Вопрос',
        ];
        $interestRu = $interestMap[$lead->interest] ?? $lead->interest;

        $name = htmlspecialchars($lead->name);
        $phone = htmlspecialchars($lead->phone);
        $comment = $lead->comment ? htmlspecialchars($lead->comment) : '—';
        $date = $lead->created_at->timezone('Europe/Minsk')->format('d.m.Y H:i');

        $text = "🔥 <b>Новая заявка!</b>\n\n"
            . "👤 <b>Имя:</b> {$name}\n"
            . "📞 <b>Телефон:</b> {$phone}\n"
            . "🎯 <b>Интерес:</b> {$interestRu}\n"
            . "💬 <b>Комментарий:</b> {$comment}\n\n"
            . "🕒 <b>Дата:</b> {$date}";

        try {
            Http::timeout(3)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            // Если телеграм упадет, заявка все равно сохранится
            Log::error('Telegram notification failed: ' . $e->getMessage());
        }
    }
}
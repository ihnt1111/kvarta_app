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

        // --- БЛОК СБОРА ИНФОРМАЦИИ ОБ ИСТОЧНИКЕ ---
        $source = $lead->source ?? [];
        $sourceText = "";

        if (!empty($source['utm_source'])) {
            // Если пришла реклама с метками
            $utmSource = htmlspecialchars($source['utm_source']);
            $utmMedium = htmlspecialchars($source['utm_medium'] ?? '');
            $utmCampaign = htmlspecialchars($source['utm_campaign'] ?? '');

            $sourceText .= "📢 <b>Реклама:</b> {$utmSource}";
            if ($utmMedium) $sourceText .= " / {$utmMedium}";
            if ($utmCampaign) $sourceText .= " (кампания: {$utmCampaign})";
            $sourceText .= "\n";
        } elseif (!empty($source['referrer']) && $source['referrer'] !== 'https://kvarta-app.onrender.com/') {
            // Если перешли с другого сайта (не с самого себя)
            $referrer = htmlspecialchars(parse_url($source['referrer'], PHP_URL_HOST) ?? $source['referrer']);
            $sourceText .= "🔗 <b>Переход с:</b> {$referrer}\n";
        } else {
            // Если зашли напрямую
            $sourceText .= "🔗 <b>Источник:</b> Прямой заход\n";
        }

        if (!empty($source['page'])) {
            $page = htmlspecialchars($source['page']);
            $sourceText .= "📄 <b>Страница:</b> {$page}";
        }

        $text = "🔥 <b>Новая заявка!</b>\n\n"
            . "👤 <b>Имя:</b> {$name}\n"
            . "📞 <b>Телефон:</b> {$phone}\n"
            . "🎯 <b>Интерес:</b> {$interestRu}\n"
            . "💬 <b>Комментарий:</b> {$comment}\n\n"
            . $sourceText . "\n\n" // <--- Вставляем инфу об источнике
            . "🕒 <b>Дата:</b> {$date}";

        try {
            Http::timeout(3)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            // все равно упадет заявка, даже если телеграм отвалится
            Log::error('Telegram notification failed: ' . $e->getMessage());
        }
    }
}
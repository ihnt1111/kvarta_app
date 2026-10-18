<?php

namespace App\Support;

use Illuminate\Http\Request;

class LeadSourceBuilder
{
    public function fromRequest(Request $request): array
    {
        return array_filter([
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign'),
            'utm_content' => $request->input('utm_content'),
            'utm_term' => $request->input('utm_term'),
            'referrer' => $request->header('referer'),
            'page' => $request->input('page_url'),
        ], fn ($value) => $value !== null && $value !== '');
    }
}
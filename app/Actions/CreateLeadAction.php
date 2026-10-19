<?php

namespace App\Actions;

use App\Exceptions\DuplicateLeadException;
use App\Models\Lead;
use App\Support\TelegramNotifier;
use Illuminate\Support\Facades\Cache;

class CreateLeadAction
{
    public function __construct(private TelegramNotifier $notifier) {}
    public function execute(array $data, array $source): Lead
    {
        $cacheKey = 'lead_lock_' . md5($data['phone']);

        if (! Cache::add($cacheKey, true, now()->addMinutes(10))) {
            throw new DuplicateLeadException();
        }

        $lead = Lead::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'interest' => $data['interest'],
            'comment' => $data['comment'] ?? null,
            'source' => $source,
        ]);

        $this->notifier->sendNewLead($lead);

        return $lead;
    }
}
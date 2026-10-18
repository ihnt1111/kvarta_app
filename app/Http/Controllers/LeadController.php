<?php

namespace App\Http\Controllers;

use App\Actions\CreateLeadAction;
use App\Exceptions\DuplicateLeadException;
use App\Http\Requests\LeadRequest;
use App\Support\LeadSourceBuilder;

class LeadController extends Controller
{
    public function store(
        LeadRequest $request,
        CreateLeadAction $action,
        LeadSourceBuilder $sourceBuilder,
    ) {
        try {
            $lead = $action->execute(
                $request->validated(),
                $sourceBuilder->fromRequest($request),
            );

            return response()->json([
                'message' => 'Спасибо! Мы свяжемся с вами.',
                'lead_id' => $lead->id,
            ], 201);
        } catch (DuplicateLeadException $e) {
            return response()->json(['message' => $e->getMessage()], 429);
        }
    }
}
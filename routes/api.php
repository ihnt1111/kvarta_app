<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/lead', [LeadController::class, 'store']);
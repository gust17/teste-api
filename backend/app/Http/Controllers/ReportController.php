<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReportJob;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        $userId = Auth::id();
        App\Http\Controllers\GenerateReportJob::dispatch($userId);

        return response()->json(['message' => 'Relatório em processamento. Você será notificado quando estiver pronto.'], 202);
    }
}

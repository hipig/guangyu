<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluatorRecordResource;
use App\Models\EvaluatorRecord;
use Illuminate\Http\Request;

class EvaluatorRecordsController extends Controller
{
    public function store(Request $request)
    {
        $record = EvaluatorRecord::create($request->only('content'));

        return EvaluatorRecordResource::make($record);
    }
}

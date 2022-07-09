<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluatorAttributeResource;
use App\Models\EvaluatorAttribute;
use Illuminate\Http\Request;

class EvaluatorAttributesController extends Controller
{
    public function index(Request $request)
    {
        $attributes = EvaluatorAttribute::query()
            ->rank()
            ->enable()
            ->get();

        return EvaluatorAttributeResource::collection($attributes);
    }
}

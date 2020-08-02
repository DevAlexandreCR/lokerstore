<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    protected $colors;

    public function __construct(Color $colors)
    {
        $this->colors = $colors;
    }

    public function index() : JsonResponse
    {
        return response()->json($this->colors->toJson());
    }
}

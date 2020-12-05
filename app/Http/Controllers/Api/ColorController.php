<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ColorsInterface;
use Illuminate\Http\JsonResponse;

class ColorController extends Controller
{
    protected ColorsInterface $colors;

    public function __construct(ColorsInterface $colors)
    {
        $this->colors = $colors;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->colors->index());
    }
}

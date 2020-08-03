<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeSizesResourse;
use App\Models\TypeSize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeSizeController extends Controller
{
    protected $typeSizes;

    public function __construct(TypeSize $typeSizes)
    {
        $this->typeSizes = $typeSizes;
    }

    public function index() : JsonResponse
    {
        return response()->json($this->typeSizes->with('sizes')->get());
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    protected Tag $tags;

    public function __construct(Tag $tags)
    {
        $this->tags = $tags;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->tags::all()->toArray());
    }
}

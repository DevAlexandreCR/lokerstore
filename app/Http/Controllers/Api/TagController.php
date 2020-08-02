<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tags;

    public function __construct(Tag $tags)
    {
        $this->tags = $tags;
    }

    public function index() : JsonResponse
    {
        return response()->json($this->tags->toArray());
    }
}

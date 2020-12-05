<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tags\IndexRequest;
use App\Http\Requests\Admin\Tags\StoreAndUpdateRequest;
use App\Interfaces\TagsInterface;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    protected TagsInterface $tags;

    public function __construct(TagsInterface $tags)
    {
        $this->authorizeResource(Tag::class, 'tag');
        $this->tags = $tags;
    }

    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        return view('admin.tags.index', [
            'tags' => $this->tags->search($request),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreAndUpdateRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAndUpdateRequest $request): RedirectResponse
    {
        $this->tags->store($request);

        return redirect()->back()->with('success', trans('messages.crud', [
                        'resource' => trans('fields.tags'),
                        'status' => trans('fields.created')
                    ]));
    }

    /**
     * Update the specified resource in storage.
     * @param StoreAndUpdateRequest $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(StoreAndUpdateRequest $request, Tag $tag): RedirectResponse
    {
        $this->tags->update($request, $tag);

        return redirect()->back()->with('success', trans('messages.crud', [
            'resource' => trans('fields.tags'),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     * Remove the specified resource from storage.
     * @param Tag $tag
     * @throws \Exception
     * @return RedirectResponse
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $this->tags->destroy($tag);

        return redirect()->back()->with('success', trans('messages.crud', [
            'resource' => trans('fields.tags'),
            'status' => trans('fields.deleted')
        ]));
    }
}

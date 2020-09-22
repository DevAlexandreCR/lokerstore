<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\IndexRequest;
use App\Http\Requests\Tags\StoreAndUpdateRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->authorizeResource(Tag::class, 'tag');
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request) : View
    {
        $search = $request->get('search', null);
        return view('admin.tags.index', [
            'tags' => $this->tag->search($search)->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreAndUpdateRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAndUpdateRequest $request) : RedirectResponse
    {
        $this->tag->create($request->all());

        return redirect()
                    ->back()
                    ->with('success', __('Tag has been created success'));
    }

    /**
     * Update the specified resource in storage.
     * @param StoreAndUpdateRequest $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(StoreAndUpdateRequest $request, Tag $tag) : RedirectResponse
    {
        $tag->update($request->all());

        return redirect()
                    ->back()
                    ->with('success', __('Tag has been updated success'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Tag $tag
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tag $tag) : RedirectResponse
    {
        $tag->delete();

        return redirect()
                ->back()
                ->with('success', __('Tag has been remove success'));
    }
}

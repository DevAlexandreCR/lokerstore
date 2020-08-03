<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\IndexRequest;
use App\Http\Requests\Tags\StoreAndUpdateRequest;
use App\Models\Tag;

class TagController extends Controller
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $search = $request->get('search', null);
        return view('admin.tags.index', [
            'tags' => $this->tag->search($search)->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAndUpdateRequest $request)
    {
        $this->tag->create($request->all());

        return redirect()
                    ->back()
                    ->with('success', __('Tag has been created success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAndUpdateRequest $request, Tag $tag)
    {
        $tag->update($request->all());

        return redirect()
                    ->back()
                    ->with('success', __('Tag has been updated success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()
                ->back()
                ->with('success', __('Tag has been remove success'));
    }
}

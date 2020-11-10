<?php


namespace App\Repositories\Api;

use App\Models\Photo;
use App\Interfaces\Api\ApiPhotosInterface;
use App\Http\Requests\Api\Photos\StoreRequest;
use App\Http\Requests\Api\Photos\DestroyRequest;

class ApiPhotos implements ApiPhotosInterface
{
    private Photo $photo;

    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }

    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request)
    {
        return $this->photo->create($request->all());
    }

    /**
     * @param DestroyRequest $request
     * @return void
     */
    public function destroy(DestroyRequest $request): void
    {
        $this->photo::destroy($request->get('photos'));
    }
}

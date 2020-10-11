<?php


namespace App\Interfaces\Api;

use App\Http\Requests\Api\Photos\StoreRequest;
use App\Http\Requests\Api\Photos\DestroyRequest;

interface ApiPhotosInterface
{
    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request);

    /**
     * @param DestroyRequest $request
     * @return mixed
     */
    public function destroy(DestroyRequest $request);
}

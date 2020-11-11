<?php


namespace App\Decorators\Api;

use Illuminate\Support\Facades\Cache;
use App\Actions\Photos\SavePhotoAction;
use App\Actions\Photos\DeletePhotoAction;
use App\Interfaces\Api\ApiPhotosInterface;
use App\Http\Requests\Api\Photos\StoreRequest;
use App\Http\Requests\Api\Photos\DestroyRequest;

class PhotosDecorator implements ApiPhotosInterface
{
    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request): void
    {
        SavePhotoAction::execute($request->get('product_id'), $request->file('photos'));

        Cache::tags(['products', 'api.products'])->flush();
    }

    /**
     * @param DestroyRequest $request
     * @return mixed
     */
    public function destroy(DestroyRequest $request): void
    {
        $deletePhotoAction = new DeletePhotoAction();
        $deletePhotoAction->execute($request->get('photos'));

        Cache::tags(['products', 'api.products'])->flush();
    }
}

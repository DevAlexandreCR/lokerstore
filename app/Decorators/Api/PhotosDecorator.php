<?php


namespace App\Decorators\Api;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Actions\Photos\Base64ToImage;
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
    public function store(StoreRequest $request)
    {
        $product = Product::findOrFail($request->get('product_id'));

        foreach ($request->get('photos') as $image) {
            $name = $product->reference . '_' . time() . '.jpg';
            $outputFile = storage_path('app/public/photos/') . $name;
            Base64ToImage::execute($image, $outputFile);
            SavePhotoAction::savePhoto($product->id, $name);
        }

        Cache::tags(['products', 'api.products'])->flush();

        return $product->photos;
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

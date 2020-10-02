<?php

namespace App\Actions\Photos;

use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;

class SavePhotoAction
{

    public function execute(int $id_product, ?array $images): void
    {
        if (empty($images)) {
            return;
        }

        foreach ($images as $image) {

            $name = $this->saveImage($image);

            $this->savePhoto($id_product, $name);
        }
    }

    /**
     * Save image file on Storage
     *
     * @param UploadedFile $image
     * @return string
     */
    private function saveImage(UploadedFile $image): string
    {
        $name = time() . '_' . $image->getClientOriginalName();
        $img = Image::make($image)->fit(540, 480)->encode('jpg', 75);
        Storage::disk('public_photos')->put($name, $img);

        return $name;
    }

    /**
     * Save or update photo Model
     *
     * @param integer $id_product
     * @param string $name
     * @return void
     */
    private function savePhoto(int $id_product, string $name): void
    {
        $photo = new Photo;
        $photo->product_id = $id_product;
        $photo->name = $name;

        $photo->save();
    }
}

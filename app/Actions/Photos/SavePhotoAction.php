<?php

namespace App\Actions\Photos;

use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SavePhotoAction
{
    /**
     * @param int $id_product
     * @param array|UploadedFile|null $images
     */
    public static function execute(int $id_product, $images): void
    {
        if (empty($images)) {
            return;
        }

        if (is_object($images)) {
            $name = self::saveImage($images);

            self::savePhoto($id_product, $name);

            return;
        }

        if (is_array($images)) {
            foreach ($images as $image) {
                $name = self::saveImage($image);

                self::savePhoto($id_product, $name);
            }
        }
    }

    /**
     * Save image file on Storage
     *
     * @param UploadedFile $image
     * @return string
     */
    private static function saveImage(UploadedFile $image): string
    {
        $name = $image->getClientOriginalName();
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
    public static function savePhoto(int $id_product, string $name): void
    {
        $photo = new Photo();
        $photo->product_id = $id_product;
        $photo->name = $name;

        $photo->save();
    }
}

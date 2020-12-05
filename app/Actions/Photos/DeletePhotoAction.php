<?php

namespace App\Actions\Photos;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class DeletePhotoAction
{
    public function execute(?array $idsPhotos): void
    {
        if (empty($idsPhotos)) {
            return;
        }

        foreach ($idsPhotos as $id) {
            $name = $this->deletePhoto($id);

            $this->deleteImage($name);
        }
    }

    /**
     * Deleting file image from storage
     *
     * @param string $name
     * @return void
     */
    private function deleteImage(string $name): void
    {
        Storage::disk('public')->delete('photos/' . $name);
    }

    /**
     * Deleteing Photo model from DB
     *
     * @param integer $photo_id
     * @return string
     */
    private function deletePhoto(int $photo_id): string
    {
        $photo = Photo::findOrFail($photo_id);
        $name = $photo->name;
        $photo->delete();

        return $name;
    }
}

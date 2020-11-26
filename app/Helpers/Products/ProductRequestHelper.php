<?php

namespace App\Helpers\Products;

class ProductRequestHelper
{
    public static function transform(array $data): array
    {
        $newDataArray = $data;
        (array_key_exists('category', $data)) ? $newDataArray['category'] = $data['category'] :
            $newDataArray['category'] = null;
        ($newDataArray['category'] === trans('actions.choose_category')) ? $newDataArray['category'] = null : null;
        array_key_exists('orderBy', $data) ? $newDataArray['orderBy'] = $data['orderBy'] :
            $newDataArray['orderBy'] = 'desc';
        (array_key_exists('search', $data)) ? $newDataArray['search'] = $data['search'] :
            $newDataArray['search'] = null;
        (array_key_exists('tags', $data)) ? $newDataArray['tags'] =
            self::getArrayTags(self::getArrayData($data['tags'])) :
            $newDataArray['tags'] = null;
        (array_key_exists('colors', $data)) ? $newDataArray['colors'] = self::getArrayData($data['colors']) :
            $newDataArray['colors'] = null;
        (array_key_exists('sizes', $data)) ? $newDataArray['sizes'] = self::getArrayData($data['sizes']) :
            $newDataArray['sizes'] = null;
        (array_key_exists('price', $data)) ? $newDataArray['price'] = $data['price'] :
            $newDataArray['price'] = null;

        return $newDataArray;
    }

    private static function getArrayTags(array $dataTags): array
    {
        $newArray = [];

        foreach ($dataTags as $key => $tag) {
            if (is_string($key)) {
                $newArray = $dataTags;
                break;
            }

            $newArray[$tag] = $tag;
        }

        return $newArray;
    }

    /**
     * @param mixed $data
     * @return array
     */
    private static function getArrayData($data): array
    {
        $newArray = [];

        if (is_string($data)) {
            $newArray[0] = $data;
        } else {
            $newArray = $data;
        }

        return $newArray;
    }
}

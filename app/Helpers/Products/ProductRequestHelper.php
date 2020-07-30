<?php

namespace App\Helpers\Products;

Class ProductRequestHelper {
    
    public static function transform(array $data) 
    {
        $newDataArray = $data;
        (array_key_exists('category', $data)) ? '' : $newDataArray['category'] = null;
        ($newDataArray['category'] === __("Choose category")) ? $newDataArray['category'] = null : '';
        (array_key_exists('orderBy', $data) && $data['orderBy'] === __("Less recent")) ? $newDataArray['orderBy'] = 'asc' : $newDataArray['orderBy'] = 'desc';
        (array_key_exists('search', $data)) ? $newDataArray['search'] = $data['search'] : $newDataArray['search'] = null;
        (array_key_exists('tags', $data)) ? $newDataArray['tags'] = self::getArrayTags($data['tags']) : $newDataArray['tags'] = null;

        return $newDataArray;
    }

    private static function getArrayTags(array $dataTags) : array
    {
        $newArray = [];

        foreach ($dataTags as $key => $tag) {
            if (gettype($key) === 'string')
            {
                $newArray = $dataTags;
            break;
            }
            else 
            {
                $newArray[$tag] = $tag;
            }
        }

        return $newArray;
    }
}


    
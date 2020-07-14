<?php

namespace App\Adapters\Products;

Class DataRequestAdapter {
    
    public static function transform(array $data) 
    {
        $newDataArray = $data;
        (array_key_exists('category', $data)) ? '' : $newDataArray['category'] = null;
        ($newDataArray['category'] === __("Choose category")) ? $newDataArray['category'] = null : '';
        (array_key_exists('orderBy', $data) && $data['orderBy'] === __("Less recent")) ? $newDataArray['orderBy'] = 'asc' : $newDataArray['orderBy'] = 'desc';
        (array_key_exists('tags', $data)) ? $newDataArray['tags'] = $data['tags'] : $newDataArray['tags'] = [];
        (array_key_exists('search', $data)) ? $newDataArray['search'] = $data['search'] : $newDataArray['search'] = null;

        return $newDataArray;
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\DestroyRequest;
use App\Http\Requests\Api\Photos\StoreRequest;
use App\Interfaces\Api\ApiPhotosInterface;
use Illuminate\Http\JsonResponse;

class PhotosController extends Controller implements ApiPhotosInterface
{
    private ApiPhotosInterface $photos;

    public function __construct(ApiPhotosInterface $photos)
    {
        $this->photos = $photos;
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $photo = $this->photos->store($request);

        return response()->json([
            'status' => [
                'status'  => 'OK',
                'message' => trans('messages.crud', [
                    'resource' => trans('fields.images'),
                    'status' => trans('fields.created')
                ]),
                'code'    => 200,
            ],
            'photo' => $photo,
        ]);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(DestroyRequest $request): JsonResponse
    {
        $this->photos->destroy($request);

        return response()->json([
            'status' => [
                'status'  => 'OK',
                'message' => trans('messages.crud', [
                    'resource' => trans('fields.images'),
                    'status' => trans('fields.deleted')
                ]),
                'code'    => 200,
            ],
        ]);
    }
}

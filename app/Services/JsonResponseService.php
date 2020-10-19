<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponseService
 * @package App\Services
 */
class JsonResponseService
{
    /**
     * @param array $resource
     * @param int $code
     *
     * @return JsonResponse
     */
    public function success($resource = [], $code = Response::HTTP_OK)
    {
        return $this->putAdditionalMeta($resource, 'success')
            ->response()
            ->setStatusCode($code);
    }

    /**
     * @param array $resource
     * @param int $code
     *
     * @return JsonResponse
     */
    public function fail($resource = [], $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return $this->putAdditionalMeta($resource, 'failed')
            ->response()
            ->setStatusCode($code);
    }

    /**
     * @param $resource
     * @param $status
     *
     * @return JsonResource
     */
    private function putAdditionalMeta($resource, $status)
    {
        $merged = array_merge($resource->additional ?? [], [
            'status' => $status
        ]);

        if ($resource instanceof JsonResource) {
            return $resource->additional($merged);
        }

        if (is_array($resource)) {
            return (new JsonResource(collect($resource)))->additional($merged);
        }

        throw new Exception('Invalid type of resource.');
    }
}

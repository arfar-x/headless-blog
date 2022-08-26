<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;

class ErrorResource extends JsonResource
{

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $statusCode = 500, $withTrace = false)
    {
        parent::__construct($resource);

        $this->statusCode = $statusCode;
        $this->withTrace = $withTrace;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /**
         * Return array like [0 => [$error, ...]]
         * So to collapse it we merge two arrays then return them
         * as a single array to be encoded by JSON
         */
        $messageResource = (new MessageResource([
            "error" => true,
            "message" => $this->getMessage()
        ]));

        $debug = [
            "debug" => $this->when(! app()->isProduction(), [
                "line" => $this->getLine(),
                "file" => $this->getFile(),
                "code" => $this->getCode(),
                "trace"=> $this->when($this->withTrace, $this->getTrace())
            ])
        ];

        return array_merge_recursive($messageResource->toArray($request), $debug);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return (new ResourceResponse($this))->toResponse($request)->setStatusCode($this->statusCode);
    }
}

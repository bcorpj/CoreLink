<?php

namespace Singlephon\Corelink\Intentions;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

abstract class Syncable
{
    protected Service $service;
    protected JsonResource $resource;

    /**
     * @param Service $service
     * @param JsonResource $resource
     */
    public function __construct(Service $service, JsonResource $resource)
    {
        $this->service = $service;
        $this->resource = $resource;
    }

    public function sync(?string $route): array
    {
        /*
         * It will send JsonResource to service
         */
        $fullRoute = $this->getUrl($route);
        $resourceName = Str::of($this->resource::class)->afterLast('\\')->before('Resource');
        $data = Http::withBody($this->resource->toJson(), 'application/json')
            ->withHeaders(['Resource' => (string) $resourceName])
            ->post($fullRoute)
            ->json();

        return [$this->service, $data];
    }

    protected function getUrl(?string $route): string
    {
        return $this->service->url . '/api' . $this->routes() [$route ?: 'notify'];
    }

    abstract protected function routes (): array;



}

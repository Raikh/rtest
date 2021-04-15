<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    protected $preserveAllQueryParameters = true;
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = UserResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}

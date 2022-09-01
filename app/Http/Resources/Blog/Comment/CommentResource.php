<?php

namespace App\Http\Resources\Blog\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "article_id" => $this->article_id,
            "publisher_name" => $this->publisher_name,
            "publisher_email" => $this->publisher_email,
            "body" => $this->body,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}

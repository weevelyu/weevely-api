<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->comment_id == null)
            return [
                'user_id' => $this->user_id,
                'post_id' => $this->post_id,
                'type' => $this->type,
                'date' => $this->date
            ];
        else
            return [
                'user_id' => $this->user_id,
                'comment_id' => $this->comment_id,
                'type' => $this->type,
                'date' => $this->date
            ];
    }
}

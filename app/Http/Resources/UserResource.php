<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'posts' => $this->posts !== null ? $this->posts : '0',
            'followers' => $this->followers !== null ? $this->followers : '0',
            'following' => $this->following !== null ? $this->following : '0',
            'email' => $this->email,
            'profile_picture_url' => $this->profile_picture_url !== null ? $this->profile_picture_url : '',
            'api_token' => $this->api_token
        ];
    }
}

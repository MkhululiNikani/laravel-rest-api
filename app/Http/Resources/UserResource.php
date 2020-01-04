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
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'posts' => $this->posts !== null ? $this->posts : '0',
            'followers' => $this->followers !== null ? $this->followers : '0',
            'profile_picture_url' => $this->profile_picture_url !== null ? $this->profile_picture_url : '',
            'following' => $this->following !== null ? $this->following : '0',
            'username' => $this->username,
            'email' => $this->email,
            'api_token' => $this->api_token
        ];
    }
}

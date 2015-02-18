<?php namespace App\Services\Twitter\Parsers;

class User {

    public function parse($status)
    {
        return [
            'id'      => $status->user->id_str,
            'account' => $status->user->screen_name,
            'name'    => $status->user->name,
            'avatar'  => $status->user->profile_image_url,
        ];
    }

}
<?php namespace App\Services\Twitter\Parsers;

class Media {

    public function parse($status)
    {
        $normal = ! empty($status->entities->media[0]->media_url) ? $status->entities->media[0]->media_url : null;

        return [
            'normal' => $normal,
            'small'  => $this->small($status),
            'type'   => $this->type($normal),
        ];
    }

    private function small($status)
    {
        $small = null;

        if ( ! empty($status->entities->media[0]))
        {
            $media = $status->entities->media[0];

            $small = $media->media_url;
            if (isset($media->sizes->small))
            {
                $small .= ':small';
            }
            else if (isset($media->sizes->medium))
            {
                $small .= ':medium';
            }
        }

        return $small;
    }

    private function type($normal)
    {
        if (empty($normal))
        {
            return null;
        }
        $normal = mb_strtolower($normal);

        $extensions = ['png', 'jpg', 'jpeg', 'gif'];
        foreach ($extensions as $extension)
        {
            if (strpos($normal, '.' . $extension) !== false)
            {
                return 'image';
            }
        }

        return 'video';
    }

}
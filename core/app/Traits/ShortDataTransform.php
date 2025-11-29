<?php

namespace App\Traits;

trait ShortDataTransform {

    protected function transformShort($short, $user = null) {
        if (!$short) {
            return null;
        }

        $fileUrl = match ($short->storage_driver) {
            'wasabi' => getS3FileUri($short->name),
            'local'  => asset(getFilePath('shorts') . '/' . $short->name),
            default  => route('short.file', $short->name),
        };

        $short->file_url  = $fileUrl;
        $short->extension = pathinfo($short->name, PATHINFO_EXTENSION);

        $short->liked = $user ? $short->likes()->where('user_id', $user->id)->exists() : false;
        $short->saved = $user ? $short->savedShorts()->where('user_id', $user->id)->exists() : false;

        return $short;
    }
}

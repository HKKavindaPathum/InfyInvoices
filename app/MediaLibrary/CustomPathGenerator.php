<?php

namespace App\MediaLibrary;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 */
class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;

        switch ($media->collection_name) {
            case User::PROFILE:
                return str_replace('{PARENT_DIR}', User::PROFILE, $path);
            case Product::Image:
                return str_replace('{PARENT_DIR}', Product::Image, $path);
            case Setting::PATH:
                return str_replace('{PARENT_DIR}', Setting::PATH, $path);
            case Payment::PAYMENT_ATTACHMENT:
                return str_replace('{PARENT_DIR}', Payment::PAYMENT_ATTACHMENT, $path);
            case 'default':
                return '';
        }
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}

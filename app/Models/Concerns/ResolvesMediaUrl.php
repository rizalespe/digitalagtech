<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ResolvesMediaUrl
{
    /**
     * Resolve a stored media path to a public URL.
     *
     * Paths under "images/" are bundled assets in public/, full URLs are returned
     * as-is, and anything else is an upload on the "public" disk.
     */
    protected function mediaUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}

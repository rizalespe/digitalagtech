<?php

namespace App\Filament\Support;

use Filament\Forms;
use Illuminate\Support\HtmlString;

class ImageField
{
    /**
     * Returns a pair of [Placeholder preview, FileUpload] for an image field
     * whose stored value may be a static public path (images/…) rather than
     * a Storage disk path.  The placeholder shows the current image; the
     * FileUpload only writes when a new file is actually chosen.
     */
    public static function make(string $field, string $label, string $directory): array
    {
        return [
            Forms\Components\Placeholder::make("{$field}_preview")
                ->label("Current {$label}")
                ->content(fn ($record) => $record?->{$field}
                    ? new HtmlString(
                        '<img src="'.self::url($record->{$field}).'" '
                        .'style="max-height:140px;border-radius:8px;display:block">'
                    )
                    : new HtmlString('<span style="color:#888">No image set</span>'))
                ->visibleOn('edit')
                ->columnSpanFull(),

            Forms\Components\FileUpload::make($field)
                ->label("Upload New {$label}")
                ->helperText('Leave empty to keep the current image.')
                ->image()
                ->disk('public')
                ->directory($directory)
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(1200)
                ->columnSpanFull()
                // Never include in save data when empty — preserves old path.
                ->dehydrated(fn ($state) => filled($state))
                // Clear display state so Filament doesn't try to resolve old
                // public-directory paths against the storage disk.
                ->afterStateHydrated(fn (Forms\Components\FileUpload $component) =>
                    $component->state(null)),
        ];
    }

    public static function resolveUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        return self::url($path);
    }

    private static function url(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        // Legacy static paths live in public/images/ and are served via asset().
        // New uploads from the storage disk start with the directory name (e.g. "news/…").
        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    }
}

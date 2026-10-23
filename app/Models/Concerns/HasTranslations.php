<?php

namespace App\Models\Concerns;

/**
 * Automatically serves the _en column when the app locale is 'en',
 * falling back to the base column when the _en column is empty.
 *
 * Usage: add `use HasTranslations;` to a model and declare:
 *   protected array $translatable = ['title', 'description', ...];
 */
trait HasTranslations
{
    public function getAttribute($key): mixed
    {
        if (
            in_array($key, $this->translatable ?? []) &&
            app()->getLocale() !== 'id'
        ) {
            $enKey = $key . '_en';
            $enValue = $this->attributes[$enKey] ?? null;

            if (!empty($enValue)) {
                return $enValue;
            }
        }

        return parent::getAttribute($key);
    }

    /**
     * Return the raw value for a field in a specific locale,
     * regardless of the active app locale.
     */
    public function getTranslation(string $field, string $locale): mixed
    {
        if ($locale === 'id') {
            return $this->attributes[$field] ?? null;
        }

        $enKey = $field . '_en';
        return $this->attributes[$enKey] ?? $this->attributes[$field] ?? null;
    }
}

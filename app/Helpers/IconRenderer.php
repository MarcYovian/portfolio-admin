<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class IconRenderer
{
    public static function render(?string $icon, ?string $label = null): string
    {
        if (blank($icon)) {
            return e($label ?? '');
        }

        // Mode 1: Raw SVG
        if (Str::startsWith($icon, '<svg')) {
            return $icon . ($label ? ' ' . e($label) : '');
        }

        // Mode 2: Nama tanpa prefix → tambahkan otomatis
        if (! Str::startsWith($icon, 'heroicon-')) {
            $icon = 'heroicon-o-' . $icon;
        }

        // Mode 3: Heroicon dengan prefix
        return "<x-filament::icon icon=\"{$icon}\" class=\"w-5 h-5 text-gray-600 inline-block mr-1\" />"
            . ($label ? e($label) : '');
    }
}

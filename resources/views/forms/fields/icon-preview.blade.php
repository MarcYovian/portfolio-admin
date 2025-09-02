@php
    $state = $get('icon');
@endphp

@if (blank($state))
    <span class="text-gray-400">No icon preview</span>
@elseif (Str::startsWith($state, '<svg'))
    {!! $state !!}
@else
    <x-filament::icon :icon="Str::startsWith($state, 'heroicon-') ? $state : 'heroicon-o-' . $state" class="w-6 h-6 text-gray-600" />
@endif

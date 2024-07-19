@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm p-2 rounded bg-green-200 text-green-700']) }}>
        {{ $status }}
    </div>
@endif

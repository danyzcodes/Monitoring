@props(['value'])

@php
    $value = $value ?? '-';
    $lower = strtolower($value);
    
    $colorClass = match(true) {
        // SUCCESS / GREEN
        str_contains($lower, 'ok') || 
        str_contains($lower, 'success') || 
        str_contains($lower, 'active') || 
        str_contains($lower, 'completed') || 
        str_contains($lower, 'done') || 
        str_contains($lower, 'finish') || 
        str_contains($lower, 'go live') || 
        str_contains($lower, 'selesai') || 
        str_contains($lower, 'approved') || 
        str_contains($lower, 'ps') => 'bg-green-50 text-green-700 border-green-100',

        // WARNING / AMBER
        str_contains($lower, 'wait') || 
        str_contains($lower, 'pending') || 
        str_contains($lower, 'progress') || 
        str_contains($lower, 'survey') || 
        str_contains($lower, 'inisiasi') || 
        str_contains($lower, 'validasi') ||
        str_contains($lower, 'perijinan') ||
        str_contains($lower, 'drm') ||
        str_contains($lower, 'matdev') ||
        str_contains($lower, 'instalasi') => 'bg-amber-50 text-amber-700 border-amber-100',

        // DANGER / RED
        str_contains($lower, 'fail') || 
        str_contains($lower, 'error') || 
        str_contains($lower, 'cancel') || 
        str_contains($lower, 'kendala') || 
        str_contains($lower, 'rejected') ||
        str_contains($lower, 'stop') => 'bg-red-50 text-red-700 border-red-100',

        // INFO / BLUE
        str_contains($lower, 'new') || 
        str_contains($lower, 'input') || 
        str_contains($lower, 'order') || 
        str_contains($lower, 'design') || 
        str_contains($lower, 'process') ||
        str_contains($lower, 'on desk') ||
        str_contains($lower, 'uji terima') ||
        str_contains($lower, 'submission') ||
        str_contains($lower, 'submitted') ||
        str_contains($lower, 'submited') => 'bg-blue-50 text-blue-700 border-blue-100',

        // PURPLE (Specifics)
        str_contains($lower, 'rekon') => 'bg-purple-50 text-purple-700 border-purple-100',

        // VIOLET (Default Fallback for non-empty)
        $value !== '-' => 'bg-violet-50 text-violet-700 border-violet-100',

        // DEFAULT (Slate/Gray for empty/dash)
        default => 'bg-slate-100 text-slate-600 border-slate-200'
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold border $colorClass"]) }}>
    {{ $value }}
</span>

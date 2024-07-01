<div x-data="{ show: true }"
     x-show="show"
     x-init="() => { if ({{ $autoClose ? 'true' : 'false' }}) setTimeout(() => show = false, {{ $autoCloseTime }}); }"
     class="alert {{ $alertClass }} d-flex align-items-center"
     role="alert"
     style="display: none;">
    <div class="mr-2">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-5 w-5 text-{{ $iconColor }}" />
    </div>
    <div>
        <h3 class="mb-0">{{ $message }}</h3>
    </div>
    <button type="button" class="ml-auto btn-close" aria-label="Close" @click="show = false"></button>
</div>

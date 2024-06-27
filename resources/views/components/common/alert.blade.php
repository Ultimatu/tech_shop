<div x-data="{ show: true }"
     x-show="show"
     x-init="() => { if ({{ $autoClose() ? 'true' : 'false' }}) setTimeout(() => show = false, {{ $autoCloseTime() }}); }"
     class="rounded-md p-4 mb-4 {{ $alertClass() }}">
    <div class="flex">
        <div class="flex-shrink-0">
            <x-dynamic-component :component="'heroicon-o-' . $icon()" class="h-5 w-5 text-{{ $iconColor() }}" />
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium">
                {{ $message }}
            </h3>
        </div>
        <div class="pl-3 ml-auto">
            <div class="-mx-1.5 -my-1.5">
                <button @click="show = false" type="button"
                    class="inline-flex rounded-md p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-gray-900">
                    <span class="sr-only">Dismiss</span>
                    <x-dynamic-component :component="'heroicon-o-' . $closeIcon()" class="h-5 w-5 text-gray-400" />
                </button>
            </div>
        </div>
    </div>
</div>

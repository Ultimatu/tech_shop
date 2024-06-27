@if ($avatarImage() !== asset('assets/images/default-avatar.png'))
    <img src="{{ $avatarImage() }}" class="{{ $avatarClass() }} rounded-full" alt="Avatar">
@else
    <div class="{{ $avatarClass() }} {{ $avatarColor() }} rounded-full flex items-center justify-center text-white">
        {{ $avatarText() }}
    </div>
@endif

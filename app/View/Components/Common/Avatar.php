<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    public ?string $filePath;
    public string $class;
    public string $initials;

    /**
     * Create a new component instance.
     */
    public function __construct(string $filePath = null, string $class = '', string $initials = '')
    {
        $this->filePath = $filePath;
        $this->class = $class;
        $this->initials = $initials ?: $this->generateInitials();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.avatar');
    }

    /**
     * Get the URL for the avatar image.
     */
    public function avatarUrl(): string
    {
        return $this->filePath && !str_contains($this->filePath, 'assets/images') 
            ? asset('storage/' . $this->filePath) 
            : asset($this->filePath);
    }

    /**
     * Generate CSS class for the avatar.
     */
    public function avatarClass(): string
    {
        return $this->class;
    }

    /**
     * Generate initials for the avatar.
     */
    public function generateInitials(): string
    {
        $user = auth()->user();
        if (!$user || !$user->name) {
            return '';
        }

        $initials = '';
        $names = explode(' ', $user->name);
        foreach ($names as $name) {
            if (!empty($name)) {
                $initials .= strtoupper($name[0]);
            }
        }

        return $initials;
    }

    /**
     * Get random color for the avatar.
     */
    public function avatarColor(): string
    {
        $colors = [
            'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-red-500',
            'bg-indigo-500', 'bg-purple-500', 'bg-pink-500', 'bg-blue-400',
            'bg-green-400', 'bg-yellow-400', 'bg-red-400', 'bg-indigo-400',
            'bg-purple-400', 'bg-pink-400', 'bg-blue-300', 'bg-green-300',
            'bg-yellow-300', 'bg-red-300', 'bg-indigo-300', 'bg-purple-300',
            'bg-pink-300',
        ];
        return $colors[array_rand($colors)];
    }

    /**
     * Get text for the avatar.
     */
    public function avatarText(): string
    {
        return $this->initials;
    }

    /**
     * Get image URL for the avatar.
     */
    public function avatarImage(): string
    {
        return $this->avatarUrl();
    }
}

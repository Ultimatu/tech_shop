<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $type;
    public string $message;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function render(): View|Closure|string
    {
        return view('components.common.alert');
    }

    public function alertClass(): string
    {
        return match ($this->type) {
            'success' => 'bg-green-100 text-green-700',
            'error' => 'bg-red-100 text-red-700',
            'warning' => 'bg-yellow-100 text-yellow-700',
            'info' => 'bg-blue-100 text-blue-700',
            default => 'bg-blue-100 text-blue-700',
        };
    }

    public function icon(): string
    {
        return match ($this->type) {
            'success' => 'check-circle',
            'error' => 'exclamation-circle',
            'warning' => 'exclamation-triangle',
            'info' => 'information-circle',
            default => 'information-circle',
        };
    }

    public function closeIcon(): string
    {
        return 'x-circle';
    }

    public function iconColor(): string
    {
        return match ($this->type) {
            'success' => 'green-700',
            'error' => 'red-700',
            'warning' => 'yellow-700',
            'info' => 'blue-700',
            default => 'blue-700',
        };
    }

    public function autoClose(): bool
    {
        return $this->type !== 'error';
    }

    public function autoCloseTime(): int
    {
        return 5000; // Time in milliseconds
    }

    public function shouldRender()
    {
        return strlen($this->message) > 0;
    }
}

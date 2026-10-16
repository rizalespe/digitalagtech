<?php

namespace App\Enums;

enum ToolkitStage: string
{
    case Discover = 'discover';
    case Build = 'build';
    case Scale = 'scale';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}

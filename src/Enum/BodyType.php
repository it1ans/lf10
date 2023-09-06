<?php

namespace App\Enum;

enum BodyType: string
{
    case NORMAL = 'normal';
    case DAINTILY = 'daintily';
    case STRONG = 'strong';

    public function define(): float
    {
        return match($this) {
            BodyType::NORMAL => 0.9,
            BodyType::DAINTILY => 0.9 * 0.9,
            BodyType::STRONG => 0.9 * 1.1,
        };
    }
}

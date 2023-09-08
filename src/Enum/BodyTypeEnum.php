<?php

namespace App\Enum;

enum BodyTypeEnum: string
{
    use LabelTrait;

    case NORMAL = 'normal';
    case DAINTILY = 'daintily';
    case STRONG = 'strong';

    public function define(): float
    {
        return match($this) {
            BodyTypeEnum::NORMAL => 0.9,
            BodyTypeEnum::DAINTILY => 0.9 * 0.9,
            BodyTypeEnum::STRONG => 0.9 * 1.1,
        };
    }
}

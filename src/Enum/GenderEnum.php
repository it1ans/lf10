<?php

namespace App\Enum;

enum GenderEnum: string
{
    use LabelTrait;

    case FEMALE = 'female';
    case MALE = 'male';
}

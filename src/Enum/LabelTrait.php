<?php

namespace App\Enum;

trait LabelTrait
{
    public function label(self $choice): string
    {
        return ucfirst($choice->value);
    }
}
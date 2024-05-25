<?php

namespace App\Component\Doctrine\Types;

enum EnumProductStatus: string
{
    case AVAILABLE = "AVAILABLE";
    case SOLD = "SOLD";
    case RESERVED = "RESERVED";
}

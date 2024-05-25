<?php

namespace App\Component\Doctrine\Types;

enum EnumProductOrderStatus: string
{
    case ORDER_STATUS_CANCELED = 'CANCELED';
    case ORDER_STATUS_COMPLETE = 'COMPLETE';
    case ORDER_STATUS_on_HOLD = 'ON_HOLD';
    case ORDER_STATUS_PROCESSING = 'PROCESSING';
    case ORDER_STATUS_NEW = 'NEW';
    case ORDER_STATUS_PAYMENT_REVIEW = 'PAYMENT_REVIEW';
}

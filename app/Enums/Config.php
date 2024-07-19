<?php

namespace App\Enums;

enum Config: string
{
    case PAYSTACK_SECRET = 'paystack.secret';

    case PAYSTACK_PUBLIC = 'paystack_public';

    case BANK_NAME = 'bank.name';
    case BANK_ACCOUNT_NAME = 'bank.account_name';
    case BANK_ACCOUNT_NUMBER = 'bank.account_number';
    case BANK_PAYMENT_INFO = 'bank.instruction';

    case BUSINESS_NAME = 'name';
}

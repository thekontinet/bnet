<?php

namespace App\Enums;

enum Config: string
{
    case PAYSTACK_SECRET = 'paystack_secret';
    case PAYSTACK_PUBLIC = 'paystack_public';

    case BANK_NAME = 'bank_name';
    case BANK_ACCOUNT_NAME = 'bank_account_name';
    case BANK_ACCOUNT_NUMBER = 'bank_account_number';

    case BUSINESS_NAME = 'business_name';
    case BUSINESS_LOGO = 'business_logo';
}

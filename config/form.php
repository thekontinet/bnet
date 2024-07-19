<?php

use App\Enums\Config;

return [
  'payment' => [
      [
          'title' => 'Bank Detail Settings',
          'description' => 'Update your bank info so customers can have the option to pay directly to your bank account',
          'fields' => [
              ['name' => Config::BANK_NAME->value, 'label' => 'Bank Name'],
              ['name' => Config::BANK_ACCOUNT_NAME->value, 'label' => 'Account Name'],
              ['name' => Config::BANK_ACCOUNT_NUMBER->value, 'label' => 'Account Number']
          ]
      ],
      [
          'title' => 'Paystack Settings',
          'description' => 'Update your paystack credentials for customers to pay using paystack',
          'fields' => [
              ['name' => Config::PAYSTACK_SECRET->value, 'label' => 'Paystack Secret Key'],
          ]
      ]
  ]
];

<?php

return [
    'auth' => [
        'reset' => [
            'subject' => 'Forgot password from Viettel Booking',
            'success_subject' => 'Reset password successfully',
        ],
        'register' => [
            'subject' => 'Account registered from Viettel Booking',
            'success_subject' => 'Account registered successfully',
        ],
        'change_email' => [
            'subject' => 'Your email has been changed'
        ]
    ],
    'flight' => [
        'hold_success_subject' => 'Hold flight confirmed from Viettel Booking',
        'commit_success_subject' => 'Your e-ticket from Viettel Booking'
    ],
    'payment' => [
        'instruction' => 'Bank transfer instruction from Viettel Booking',
        'paid_success_subject' => 'Flight payment confirmed from Viettel Booking'
    ],
    'promotions' => [
        'delivery_subject' => 'Receive promo code from partner'
    ],
];
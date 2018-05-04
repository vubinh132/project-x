<?php

return [
    'common' => [
        'unknown' => 'Server error!',
        'validate_error' => 'The given data were failed validation!',
        'invalid_data_error' => 'The given data is invalid!',
        'api_not_found' => 'The API does not exist!',
    ],
    'auth' => [
        'unauthenticated' => 'You are not authorized to access!'
    ],
    'airport' => [
        'not_found' => 'The airport does not exists!',
    ],
    'airline' => [
        'not_found' => 'The airline does not exists!',
    ],
    'promotion' => [
        'not_found' => 'The promotion does not exists!',
    ],
    'news' => [
        'not_found' => 'The news does not exists!',
    ],
    'faq' => [
        'not_found' => 'The FAQ does not exists!',
    ],
    'user' => [
        'activation_token_not_found' => 'The activation token does not exists!',
        'email_or_phone_not_found' => 'The email or phone number does not exists!',
        'email_not_found' => 'The email does not exists!',
        'phone_not_found' => 'The phone number does not exists!',
        'otp_incorrect' => 'OTP is not correct!',
        'otp_expired' => 'OTP is expired!',
        'password_incorrect' => 'Password is not correct!',
        'maximum_otp_send' => 'You have received maximum number of OTP today.',
        'email_exists' => 'Your email was registered, please login using email.',
        'phone_exists' => 'Your phone number was registered, please login using phone number.',
        'password_invalid' => 'Your password is not valid. Password of 6 - 20 characters, has at least 1 uppercase letter or lowercase letter and 1 number.',
        'promotion_not_found' => 'The promotion does not exists!',
        'promotion_out_of_number' => 'The promotion is out of number!',
        'receiver_exists' => 'You have already received this promotion!',
        'different_new_password' => 'New password must be different from old password',
        'different_new_phone' => 'New phone number must be different from old phone number '
    ],
    'flight_order' => [
        'invalid_data' => 'Your flight may no longer available, please try to search flight again!',
        'booking_no_not_found' => 'Invalid booking number',
        'promotion_is_not_valid' => 'This promotion code is not valid!',
        'order_is_not_qualified' => 'Your booking is not qualified for this promotion!',
        'show' => [
            'order_is_paid' => 'Your booking was successfully paid. Your order is processing right now. please contact our operator for support!',
            'order_is_booked' => 'Your booking was successfully paid. Please check your email to view your e-ticket!',
            'order_book_error' => 'Your booking was successfully paid but your flight is not confirmed. Please contact our operator for support!',
            'order_hold_error' => 'Booking number is not found!',
            'expired' => 'Your booking was expired, please search and book again!',
        ],
        'hold' => [
            'passenger_price_invalid' => 'Passenger price is not valid!',
            'depart_price_invalid' => 'Depart price is not valid!',
            'return_price_invalid' => 'Return price is not valid!',
        ],
        'confirm' => [
            'order_pay_error' => 'Your payment was cancelled or failed!',
            'order_is_not_paid' => 'Your payment was failed!',
        ],
    ],
    'cheap_flight' => [
        'not_found' => 'There is no flights available for your searching!',
    ],
    'payments' => [
        'booking_no_not_found' => 'Booking number not found.',
        'order_expired' => 'Your booking was expired.',
        'order_is_paid_or_hold_error' => 'Hold ticket failed or ticket has been paid.',
        'booking_no_required' => 'Booking number is required.',
        'bank_not_found' => 'Bank code does not exist!'
    ],
    'notification' => [
        'not_found' => 'The notification does not exists!',
    ],
    'partner' => [
        'not_found' => 'The partner does not exists!',
    ],
    'flight_supplier' => [
        'search_error' => 'Cannot connect with airline, please try to search flight again!',
        'hold_error' => 'Cannot hold flight ticket from airline, please try to search flight again!',
        'commit_error' => 'Cannot commit flight ticket from airline, please contact with our operator for support!',
        'unable_get_availability' => 'The flight is not available, please try to search flight again!',
        'unable_get_luggage' => 'Cannot get luggage of the flight!',
        'booking_session_expired' => 'The booking session is expired, please try to search flight again!',
    ],
    'survey' => [
        'not_found' => 'The survey does not exists!',
    ],
];
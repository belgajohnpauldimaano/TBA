<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailInquiry extends Model
{
    // const EMAIL_INQUIRY_TYPES       = [
    //     '0' => ['type' => 'Select Email Inqury Type',   'email' => ''],
    //     '1' => ['type' => 'General Inquiries',          'email' => 'belgajohnpauldimaano@gmail.com'],
    //     '2' => ['type' => 'Marketing Inquiries',        'email' => 'belgajohnpauldimaano@gmail.com'],
    //     '3' => ['type' => 'Casting Inquiries',          'email' => 'belgajohnpauldimaano@gmail.com'],
    //     '4' => ['type' => 'Film Screenings',            'email' => 'belgajohnpauldimaano@gmail.com'],
    //     '5' => ['type' => 'Cinema 76 Inquiries' ,       'email' => 'belgajohnpauldimaano@gmail.com']
    // ];

    const EMAIL_INQUIRY_TYPES       = [
        '0' => ['type' => 'Select Inquiry Type',        'email' => ''],
        '1' => ['type' => 'General Inquiries',          'email' => 'info@tba.ph'],
        '2' => ['type' => 'Marketing Inquiries',        'email' => 'marketing@tba.ph'],
        '3' => ['type' => 'Casting Inquiries',          'email' => 'thirdeye@tba.ph'],
        '4' => ['type' => 'Film Screenings',            'email' => 'dev@build.com.ph'],
        '5' => ['type' => 'Cinema 76 Inquiries',        'email' => 'cinema76fs@tba.ph'],
        '6' => ['type' => 'Human Resources',            'email' => 'hr@tba.ph']
    ];

    const EMAIL_INQUIRY_TYPES_STYLE       = [
        '1' => 'primary',
        '2' => 'success',
        '3' => 'warning',
        '4' => 'danger',
        '5' => 'default',
        '6' => 'default'
    ];
}

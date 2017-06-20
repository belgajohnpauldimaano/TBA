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
        '0' => ['type' => 'Select Email Inqury Type',   'email' => ''],
        '1' => ['type' => 'General Inquiries',          'email' => 'dev@build.com.ph'],
        '2' => ['type' => 'Marketing Inquiries',        'email' => 'dev@build.com.ph'],
        '3' => ['type' => 'Casting Inquiries',          'email' => 'dev@build.com.ph'],
        '4' => ['type' => 'Film Screenings',            'email' => 'dev@build.com.ph'],
        '5' => ['type' => 'Cinema 76 Inquiries' ,       'email' => 'dev@build.com.ph']
    ];
}

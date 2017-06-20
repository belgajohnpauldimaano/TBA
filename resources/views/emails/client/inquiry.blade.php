@component('mail::message')

An inquiry has been made via the TBA website contact form. Below are the details of the inquiry:

@component('mail::table')
<table>
    <tr>
        <td>
            Name:
        </td>
        <td>
            {{ $MailInquiry->name }}
        </td>
    </tr>

    <tr>
        <td>
            E-mail:
        </td>
        <td>
            {{ $MailInquiry->email }}
        </td>
    </tr>

    <tr>
        <td>
            Message: 
        </td>
        <td>
            {{ $MailInquiry->message }}
        </td>
    </tr>
</table>
@endcomponent
Thank you!

*** This e-mail is auto-generated. Please do not reply. *** 

{{-- 
@component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}
{{-- 
Thanks,<br>
{{ config('app.name') }} --}}
@endcomponent

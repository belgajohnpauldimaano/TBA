<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;

use App\Mail\MailInquiry as MailInquiryMailer;

use App\MailingList;
use App\MailInquiry;

class MailingListController extends Controller
{
    public function index ()
    {

    }

    public function inquiry_save (Request $request)
    {
        $rules = [
            'inquiry_type'      => 'required|digits_between:1,1',
            'inquiry_name'      => 'required',
            'inquiry_email'     => 'required|email',
            'inquiry_message'   => 'required|min:15',
        ];

        $messages = [
            'inquiry_type.required'         => 'Inquiry type is required.',
            'inquiry_type.digits_between'   => 'Invalid selection of inquiry type.',
            'inquiry_name.required'         => 'Name is required.',
            'inquiry_email.required'        => 'Email address is required.',
            'inquiry_email.email'           => 'Email address is invalid.',
            'inquiry_message.required'      => 'Inquiry message is required.',
            'inquiry_message.min'           => 'Inquiry message should be minimum of 15 characters.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json([ 'errCode' => 1, 'messages' => $validator->getMessageBag() ]);
        }

        $MailInquiry = new MailInquiry();
        $MailInquiry->name = $request->inquiry_name;
        $MailInquiry->email = $request->inquiry_email;
        $MailInquiry->message = $request->inquiry_message;
        $MailInquiry->inqury_type = $request->inquiry_type;
        $MailInquiry->save();

        $other = MailInquiry::EMAIL_INQUIRY_TYPES[$request->inquiry_type];

        Mail::to($other['email'])
            ->queue(new MailInquiryMailer(['MailInquiry' => $MailInquiry, 'subject' => $other['type']]));

        return response()->json([ 'errCode' => 0, 'messages' => 'Successfully inquired' ]);
    }

    public function add_mailing_list (Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:mailing_lists,email'
        ];

        $messages = [
            'email.required' => 'Email address is required.',
            'email.email' => 'Invalid format of email address.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json([ 'errCode' => 1, 'messages' => $validator->getMessageBag() ]);
        }
        
        $MailingList            = new MailingList();
        $MailingList->email     = $request->email;
        $MailingList->status    = MailingList::EMAIL_STATUS_ACTIVE;
        $MailingList->save();



        return response()->json([ 'errCode' => 0, 'messages' => 'Email address successfully subscribed.' ]);

    }


}

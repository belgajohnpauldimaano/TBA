<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;
use Image;
use Excel;

use App\Mail\MailInquiry as MailInquiryMailer;

use App\MailingList;
use App\MailInquiry;

class MailingListController extends Controller
{
    public function index ()
    {   
        $MailInquiry = MailInquiry::paginate(10);
        $EMAIL_INQUIRY_TYPES = MailInquiry::EMAIL_INQUIRY_TYPES;

        $MailingList = MailingList::where('status', 1)->paginate(10);

        return view('cms.mail_inquiry.index', ['MailInquiry' => $MailInquiry, 'EMAIL_INQUIRY_TYPES' => $EMAIL_INQUIRY_TYPES, 'MailingList' => $MailingList]);
    }

    public function search_inquiries (Request $request)
    {
        $MailInquiry = MailInquiry::where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->mail_inquiry_search . '%');
                $q->orWhere('email', 'like', '%' . $request->mail_inquiry_search . '%');
            })
            ->where(function ($q) use ($request) {
                if ($request->mail_inquiry_type != 0)
                {
                    $q->where('inquiry_type', '=', $request->mail_inquiry_type);
                }
            })
            ->paginate(10);
        $EMAIL_INQUIRY_TYPES = MailInquiry::EMAIL_INQUIRY_TYPES;

        return view('cms.mail_inquiry.partials.search_inquiry_data', ['MailInquiry' => $MailInquiry, 'EMAIL_INQUIRY_TYPES' => $EMAIL_INQUIRY_TYPES, 'request' => $request->all()])->render();
    }

    public function mailing_list (Request $request)
    {
        $MailingList = MailingList::
            where('status', 1)
            ->where('email', 'like', '%' . $request->mail_list_search . '%')
            ->paginate(10);
        return view('cms.mail_inquiry.partials.mailing_list_data', ['MailingList' => $MailingList])->render();
    }

    public function delete_mail (Request $request)
    {
        if (!$request->id)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of email.']);
        }
        $MailingList = MailingList::
            where('id', $request->id)
            ->first();
        
        if (!$MailingList)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of email.']);
        }

        $MailingList->status = 0;
        $MailingList->delete();

        return response()->json(['errCode' => 0, 'messages' => 'Email address successfully removed.']);

    }

    public function view_inquiry (Request $request)
    {
        if (!$request->id)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of inquiry.']);
        }

        $MailInquiry = MailInquiry::where('id', $request->id)->first(['name', 'email', 'message', 'inquiry_type']);

        if (!$MailInquiry)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of inquiry.']);
        }

        return response()->json(['errCode' => 0, 'messages' => 'successfully fetched.', 'MailInquiry' => $MailInquiry, 'EMAIL_INQUIRY_TYPES' => MailInquiry::EMAIL_INQUIRY_TYPES, 'EMAIL_INQUIRY_TYPES_STYLE' => MailInquiry::EMAIL_INQUIRY_TYPES_STYLE]);
    }

    public function delete_inquiry (Request $request)
    {
        $MailInquiry = MailInquiry::where('id', $request->id)->first();
        $MailInquiry->delete();

        return response()->json(['errCode' => 0, 'messages' => 'Email address successfully removed.']);
    }

    public function mail_inquiry_export (Request $request)
    {
        $MailInquiry = MailInquiry::where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->mail_inquiry_search . '%');
                $q->orWhere('email', 'like', '%' . $request->mail_inquiry_search . '%');
            })
            ->where(function ($q) use ($request) {
                if ($request->mail_inquiry_type != 0)
                {
                    $q->where('inquiry_type', '=', $request->mail_inquiry_type);
                }
            })->get(['name', 'email', 'message', 'inquiry_type', 'created_at']);

        if ($MailInquiry->count() < 1)
        {
            return response()->json(['errCode' => 1, 'messages' => 'System could not able to generate CSV file because query doesn\'t have a result.']);
        }
        $EMAIL_INQUIRY_TYPES = MailInquiry::EMAIL_INQUIRY_TYPES;

        Excel::create('exported-inquiry-list', function ($excel) use ($MailInquiry, $EMAIL_INQUIRY_TYPES) {
                    
            $excel->setTitle('Our new awesome title');

            $excel->setCreator('TBA')
                    ->setCompany('TBA');
                    
            $excel->setDescription('List of inquiries');
            
            $excel->sheet('Inquiries', function ($sheet) use ($MailInquiry, $EMAIL_INQUIRY_TYPES) {
                
                     $sheet->row(1, [
                                'Name', 'Email Address', 'Message', 'Inquiry Type', 'Inquiry Date'
                            ]);
                    if ($MailInquiry->count() > 0)
                    {
                        foreach ($MailInquiry as $key => $mail_inquiry) 
                        {
                           $sheet->row($key + 2, [
                                $mail_inquiry->name, 
                                $mail_inquiry->email, 
                                $mail_inquiry->message,
                                $EMAIL_INQUIRY_TYPES[$mail_inquiry->inquiry_type]['type'],
                                $mail_inquiry->created_at
                            ]);
                        }
                    }

            }); 
            })->store('csv', public_path('content'));

        return response()->json(['errCode' => 0, 'messages' => 'CSV successfully exported.']);
    }

    public function mailing_list_export (Request $request)
    {
        $MailingList = MailingList::where(function ($q) use ($request) {
                // $q->where('name', 'like', '%' . $request->mail_inquiry_search . '%');
                // $q->orWhere('email', 'like', '%' . $request->mail_inquiry_search . '%');
            })->get();

        if ($MailingList->count() < 1)
        {
            return response()->json(['errCode' => 1, 'messages' => 'System could not able to generate CSV file because query doesn\'t have a result.']);
        }
        //$EMAIL_INQUIRY_TYPES = MailingList::EMAIL_INQUIRY_TYPES;

        //return json_encode($MailingList);

        Excel::create('exported-mailing-list', function ($excel) use ($MailingList) {
                    
            $excel->setTitle('Our new awesome title');

            $excel->setCreator('TBA')
                    ->setCompany('TBA');
                    
            $excel->setDescription('Mailing List');
            
            $excel->sheet('Inquiries', function ($sheet) use ($MailingList) {
                
                     $sheet->row(1, [
                                'Name',
                                'Email Address',
                                'Date Subscribed'
                            ]);
                    if ($MailingList->count() > 0)
                    {
                        foreach ($MailingList as $key => $Mailing_list) 
                        {
                           $sheet->row($key + 2, [
                                $Mailing_list->name,
                                $Mailing_list->email,
                                $Mailing_list->created_at
                            ]);
                        }
                    }

            }); 
            })->store('csv', public_path('content'));

        return response()->json(['errCode' => 0, 'messages' => 'CSV successfully exported.']);
    }



    public function inquiry_save (Request $request)
    {
        $rules = [
            'inquiry_type'      => 'required|digits_between:1,1',
            'inquiry_name'      => 'required',
            'inquiry_email'     => 'required|email',
            'inquiry_message'   => 'required|min:15',
            'g-recaptcha-response'   => 'required'
        ];

        $messages = [
            'inquiry_type.required'         => 'Inquiry type is required.',
            'inquiry_type.digits_between'   => 'Invalid selection of inquiry type.',
            'inquiry_name.required'         => 'Name is required.',
            'inquiry_email.required'        => 'Email address is required.',
            'inquiry_email.email'           => 'Email address is invalid.',
            'inquiry_message.required'      => 'Inquiry message is required.',
            'g-recaptcha-response.required'      => 'Please verify that you are not a robot.',
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
        $MailInquiry->inquiry_type = $request->inquiry_type;
        $MailInquiry->save();

        $other = MailInquiry::EMAIL_INQUIRY_TYPES[$request->inquiry_type];

        Mail::to($other['email'])
            ->queue(new MailInquiryMailer(['MailInquiry' => $MailInquiry, 'subject' => $other['type']]));


        Mail::to('dev@build.com.ph')
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
        $MailingList->name     = $request->name;
        $MailingList->email     = $request->email;
        $MailingList->status    = MailingList::EMAIL_STATUS_ACTIVE;
        $MailingList->save();



        return response()->json([ 'errCode' => 0, 'messages' => 'Email address successfully subscribed.' ]);

    }


}

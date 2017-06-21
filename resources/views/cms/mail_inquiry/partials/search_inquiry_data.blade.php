                            
                            <div class="pull-right">
                                {{ $MailInquiry->links() }}
                            </div>
                            <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Inquiry Type</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody>
                                        @if ($MailInquiry)
                                            @foreach ($MailInquiry as $inquiry)

                                                

                                                <tr>
                                                    <td>
                                                        @if($request['mail_inquiry_search'])
                                                            @if(substr_count(strtolower($inquiry->name),strtolower($request['mail_inquiry_search'])) == 0)
                                                                {{ $inquiry->name }}
                                                            @else
                                                                {!! str_ireplace($request['mail_inquiry_search'], "<span class='label bg-maroon'><strong>".($request['mail_inquiry_search'])."</strong></span>", $inquiry->name) !!}
                                                            @endif
                                                        @else
                                                            {{ $inquiry->name }} 
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($request['mail_inquiry_search'])
                                                            @if(substr_count(strtolower($inquiry->email),strtolower($request['mail_inquiry_search'])) == 0)
                                                                {{ $inquiry->email }}
                                                            @else
                                                                {!! str_ireplace($request['mail_inquiry_search'], "<span class='label bg-maroon'><strong>".($request['mail_inquiry_search'])."</strong></span>", $inquiry->email) !!}
                                                            @endif
                                                        @else
                                                            {{ $inquiry->email }}
                                                        @endif
                                                    </td>
                                                    <td>{{ str_limit($inquiry->message, 40) }}</td>
                                                    <td>
                                                        <p class="label label-{{ App\MailInquiry::EMAIL_INQUIRY_TYPES_STYLE[$inquiry->inquiry_type] }}">
                                                            {{ $EMAIL_INQUIRY_TYPES[$inquiry->inquiry_type]['type'] }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <button data-id="{{ $inquiry->id }}" class="btn btn-flat btn-block bg-olive btn-xs js-btn_view_inquiry">View</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td col-span="5">No data found</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
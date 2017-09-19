@extends('layouts.main')

{{-- @section ('styles')
    <link href="{{ asset('cms/plugins/alertifyjs/css/alertify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/plugins/alertifyjs/css/themes/bootstrap.min.css') }}" rel="stylesheet">
@endsection --}}

@section('page_title')
    Inquiries and Mailing List
@endsection

@section ('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Inquiries and Mailing List</h3>
        </div>

        <div class="box-body">
            <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#mail_inquiries" data-toggle="tab">Inquiries</a></li>
              <li class=""><a href="#subscribed_mails" data-toggle="tab">Mailing List </a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="mail_inquiries">

                <div class="row">
                    <form action="" id="form_mail_inquiries">
                        <div class="form-group col-sm-3">
                            <label for="">Inquiry Type</label>
                            <?php array_shift($EMAIL_INQUIRY_TYPES) ; ?>
                            <select name="mail_inquiry_type" id="mail_inquiry_type" class="form-control">
                                <option value="0">All</option>
                                @foreach ($EMAIL_INQUIRY_TYPES as $key => $type)
                                    <option value="{{ $key + 1 }}">{{ ($type['type']) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-sm-3">
                            <label for="">Search</label>
                            <input type="text" name="mail_inquiry_search" class="form-control" placeholder="Search">
                        </div>

                        {{ csrf_field() }}
                        <div class="col-sm-2">
                            <label for="">&nbsp;</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-flat btn-primary btn-block">Search</button>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <label for="">&nbsp;</label>
                            <div class="input-group ">
                                <span class="input-group-btn">
                                    <button href="#" class="btn btn-flat bg-olive btn-block js-mail_inquiry_export">Export to csv</button>
                                </span>
                            </div>
                        </div>
                    </form>
                    
                    <div class="col-sm-12">
                        <div id="mail_inquiries_data_holder" class=" box box-solid">
                            <div class="pull-right">
                                {{ $MailInquiry->links() }}
                            </div>
                            <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Message</th>
                                        <th>Inquiry Type</th>
                                        <th>inquire Date</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody>
                                        @if ($MailInquiry)
                                            @foreach ($MailInquiry as $inquiry)
                                                <tr>
                                                    <td><span>{{ $inquiry->name }}</span></td>
                                                    <td>{{ $inquiry->email }}</td>
                                                    <td>{{ str_limit($inquiry->message, 40) }}</td>
                                                    {{-- <td>{{ $inquiry->inquiry_type }}</td> --}}
                                                    <td>

                                                        <p class="label label-{{ App\MailInquiry::EMAIL_INQUIRY_TYPES_STYLE[$inquiry->inquiry_type] }}">
                                                            {{ $EMAIL_INQUIRY_TYPES[$inquiry->inquiry_type - 1]['type'] }}
                                                        </p>
                                                    </td>
                                                    <td>{{ Date('Y-m-d', strtotime($inquiry->created_at)) }}</td>
                                                    <td>
                                                        <!-- Single button -->
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Action <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu__action">
                                                                <li><a href="#" class="js-btn_view_inquiry" data-id="{{ $inquiry->id }}">View</a></li>
                                                                <li><a href="#" class="js-delete_inquiry" data-id="{{ $inquiry->id }}">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td col-span="5">No data found</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="subscribed_mails">
                <div class="row">
                    <div class="col-sm-4">
                        <form action="" id="form_mail_list_search">
                            {{ csrf_field() }}
                            <label for="">Search</label>
                            <div class="input-group">
                                <input type="text" name="mail_list_search" class="form-control" placeholder="Search">
                                <span class="input-group-btn">
                                    <button class="btn btn-flat btn-primary">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                        
                        <div class="col-sm-2">
                            <label for="">&nbsp;</label>
                            <div class="input-group ">
                                <span class="input-group-btn">
                                    <button href="#" class="btn btn-flat bg-olive btn-block js-mailing_list_export">Export to csv</button>
                                </span>
                            </div>
                        </div>
                    
                    <div class="col-sm-12">
                        <div id="mail_list_data_holder" class=" box box-solid">
                            <div class="pull-right">
                                {{ $MailingList->links('cms.mail_inquiry.partials.mailing_list_pagination') }}
                            </div>
                            <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Mail Address</th>
                                        <th>Date Subscribed</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody>
                                        @if ($MailingList)
                                            @foreach ($MailingList as $mail)
                                                <tr>
                                                    <td><span>{{ $mail->name }}</span></td>
                                                    <td><span>{{ $mail->email }}</span></td>
                                                    <td>
                                                        {{ date('l, jS \of F Y', strtotime($mail->created_at)) }}
                                                    </td>
                                                    <td>
                                                        <button data-id="{{ $mail->id }}" class="js-delete_mail_list btn btn-flat btn-danger btn-md js-btn_delete_mail"><i class="fa fa-trash"></i> Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td col-span="5">No data found</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->

        
        </div>

    </div>
    


    <div class="modal fade" id="js-view_inquiry_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content box box-solid">
                <div class="overlay hidden">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">View Inquiry</h4>
                </div>
                <div class="modal-body">
                    <table class="">
                        <tr>
                            <td><strong>Inquiry Type</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <p class="label" id="js-inqury_type_modal">  </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Name</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <p id="js-inqury_name_modal">  </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <p id="js-inqury_email_modal">  </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Message</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <p id="js-inqury_message_modal">  </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

@endsection

@section ('scripts')

    {{-- <script src="{{ asset('cms/plugins/alertifyjs/alertify.min.js') }}"></script> --}}
    <script>
        $('body').on('click', '.js-mail_inquiry_export', function (e) {
            e.preventDefault();
            
            var formData = new FormData($('#form_mail_inquiries')[0]);

            $.ajax({
                url : "{{ route('mail_inquiry_export') }}",
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (data) {
                    //$('#mail_inquiries_data_holder').empty();
                    //$('#mail_inquiries_data_holder').html(data);
                    if (data.errCode == 1)
                    {
                        alertify.error('' + data.messages + '');
                    }
                    else
                    {
                        alertify.success('' + data.messages + '');
                        window.location = "{{ asset('content/exported-inquiry-list.csv') }}";
                    }
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        //window.location.reload();
                    }
                } 
            });

        });

        $('body').on('click', '.js-mailing_list_export', function (e) {
            e.preventDefault();
            
            var formData = new FormData($('#form_mail_list_search')[0]);

            $.ajax({
                url : "{{ route('mailing_list_export') }}",
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (data) {
                    //$('#mail_inquiries_data_holder').empty();
                    //$('#mail_inquiries_data_holder').html(data);
                    if (data.errCode == 1)
                    {
                        alertify.error('' + data.messages + '');
                    }
                    else
                    {
                        alertify.success('' + data.messages + '');
                        window.location = "{{ asset('content/exported-mailing-list.csv') }}";
                    }
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        //window.location.reload();
                    }
                } 
            });

        });


        function fetch_record_page_specific (page)
        {
            var formData = new FormData($('#form_mail_inquiries')[0]);
            formData.append('page', page);
            $('#mail_inquiries_data_holder .overlay').removeClass('hidden');

            $.ajax({
                url : "{{ route('search_inquiries') }}",
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (data) {
                    $('#mail_inquiries_data_holder').empty();
                    $('#mail_inquiries_data_holder').html(data);
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                } 
            });
        }

        function fetch_record_mailing_list (page)
        {
            var formData = new FormData($('#form_mail_list_search')[0]);
            formData.append('page', page);
            $('#mail_list_data_holder .overlay').removeClass('hidden');

            $.ajax({
                url : "{{ route('mailing_list') }}",
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (data) {
                    $('#mail_list_data_holder').empty();
                    $('#mail_list_data_holder').html(data);
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                } 
            });
        }

        $('body').on('click', '.js-delete_mail_list', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            bootbox.confirm({
                title: "Confirm",
                message: "Are you sure you want to delete?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if (result)
                    {
                        $.ajax({
                            url : "{{ route('delete_mail') }}",
                            type : 'POST',
                            data : { id : id, _token : '{{ csrf_token() }}' },
                            success     : function (data) {
                                if (data.errCode == 1)
                                {
                                    alertify.error('' + data.messages + '');
                                }
                                else
                                {
                                    alertify.success('' + data.messages + '');
                                }
                                fetch_record_mailing_list(1);
                            },
                            error : function (xhr, ajaxOptions, thrownError)
                            {
                                if (thrownError == 'Unauthorized')
                                {
                                    window.location.reload();
                                }
                            },
                            statusCode: {
                                500: function(xhr) {
                                    window.location.reload();
                                }
                            } 
                        });   
                    }
                }
            });
            
        });

        $('body').on('submit', '#form_mail_list_search', function (e) {
            e.preventDefault();
            fetch_record_mailing_list(1);
        })

        $('body').on('submit' , '#form_mail_inquiries', function (e) {
            e.preventDefault();
            fetch_record_page_specific(1);
        });

        $('body').on('click','.js-btn_view_inquiry', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url : "{{ route('view_inquiry') }}",
                type : 'POST',
                data : { id :  id, _token : '{{ csrf_token() }}'},
                success     : function (data) {
                    console.log(data);
                    $('#js-inqury_type_modal').attr('class', 'label');

                    $('#js-inqury_type_modal').text(data.EMAIL_INQUIRY_TYPES[data.MailInquiry.inquiry_type]['type']);
                    $('#js-inqury_type_modal').addClass('label-'+data.EMAIL_INQUIRY_TYPES_STYLE[data.MailInquiry.inquiry_type]);
                    $('#js-inqury_name_modal').text(data.MailInquiry.name);
                    $('#js-inqury_email_modal').text(data.MailInquiry.email);
                    $('#js-inqury_message_modal').text(data.MailInquiry.message);
                    $('#js-view_inquiry_modal').modal();
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    console.log(thrownError);

                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        if(window.console) console.log(xhr.responseText);
                            alert('error');
                    }
                } 
            }).always(function (jqXHR) {
                console.log(jqXHR.status);
            });
        });



        $('body').on('click','.js-delete_inquiry', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            console.log(id);

            bootbox.confirm({
                title: "Confirm",
                message: "Are you sure you want to delete?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if (result)
                    {
                        $.ajax({
                            url : "{{ route('delete_inquiry') }}",
                            type : 'POST',
                            data : { id :  id, _token : '{{ csrf_token() }}'},
                            success     : function (data) {
                                window.location.reload();
                            }
                            ,
                            error : function (xhr, ajaxOptions, thrownError)
                            {
                                console.log(thrownError);

                                if (thrownError == 'Unauthorized')
                                {
                                    window.location.reload();
                                }
                            },
                            statusCode: {
                                500: function(xhr) {
                                    if(window.console) console.log(xhr.responseText);
                                        alert('error');
                                }
                            } 
                        }).always(function (jqXHR) {
                            console.log(jqXHR.status);
                        }); 
                    }
                }
            });
        });
        
        $('.mailing').addClass('active');
    </script>
@endsection
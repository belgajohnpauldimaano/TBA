@extends('frontend.layouts.main')

@section('page_title')
<title>Contact TBA</title>
@endsection

@section('styles')
    <style>
        .btn-submit{
            width: 140px;
            background-color: #000 !important;
            color: #fff !important;
        }
        .btn-submit:hover{
            opacity: .8;
        }
    </style>
@endsection

@section('container')
    <main>
        <section>
            <div class="header-title">
                <h2 class="header-title__tag">Contact</h2>
            </div>
            <div class="container">
                <div class="contact-info">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="contact-info-details">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <h4><strong>Tba Studios</strong></h4>
                                                <p>
                                                    160 Luna Mencias St., <br>
                                                    Brgy. Addition Hills, <br>
                                                    San Juan City 1500, <br>
                                                    Metro Manila, Philippines <br>
                                                </p>
                                                <p>
                                                  <strong class="clearfix">Phone</strong>
                                                  <span class="text-calibri">+632 398 1939</span>
                                                </p>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6 b-left-3">
                                                <div class="clearfix">
                                                    <div class="pull-right">
                                                        <h4 class="m-b-0 text-capitalize"><strong>General Inquiries</strong></h4>
                                                        <p class="text-calibri m-b-4">info@tba.ph</p>

                                                        <h4 class="m-b-0 text-capitalize"><strong>Marketing</strong></h4>
                                                        <p class="text-calibri m-b-4">marketing@tba.ph</p>

                                                        <h4 class="m-b-0 text-capitalize"><strong>Casting</strong></h4>
                                                        <p class="text-calibri m-b-4">thirdeye@tba.ph</p>

                                                        <h4 class="m-b-0 text-capitalize"><strong>Cinerma '76</strong></h4>
                                                        <p class="text-calibri">cinema76fs@tba.ph</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <form id="form_inquiry">
                                        <div class="form-group">
                                            <div class="help-block text-center" id="inquiry_type-error"></div>
                                            <select name="inquiry_type" id="inquiry_type" class="form-control">
                                                @foreach (App\MailInquiry::EMAIL_INQUIRY_TYPES as $key => $inquiry)
                                                    <option value="{{ $key }}">{{ $inquiry['type'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="help-block text-center" id="inquiry_name-error"></div>
                                            <input type="text" class="form-control" name="inquiry_name" id="inquiry_name" placeholder="NAME">
                                        </div>
                                        <div class="form-group">
                                            <div class="help-block text-center" id="inquiry_email-error"></div>
                                            <input type="text" class="form-control" name="inquiry_email" id="inquiry_email" placeholder="EMAIL ADDRESS">
                                        </div>
                                        <div class="form-group">
                                            <div class="help-block text-center" id="inquiry_message-error"></div>
                                            <textarea class="form-control" name="inquiry_message" id="inquiry_message" rows="9" placeholder="MESSAGE"></textarea>
                                        </div>
                                        {{ csrf_field() }}
                                        <div class="text-center">
                                          <button type="submit" class="btn btn-default center-block btn-submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mapContact"></div>
        </section>
    </main>
@endsection

@section ('scripts')
    <script>
        $('body').on('submit', '#form_inquiry', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url : "{{ route('inquiry_save') }}",
                type : 'POST',
                data : formData,
                contentType : false,
                processData : false,
                success     : function (data) {
                    
                    $('.form-group').removeClass('has-error');
                    $('.form-group').children('.help-block').html('');

                    if (data.errCode == 1)
                    {
                        var errMessages = '';
                        for(var err in data.messages)  {{-- loop to each error --}}
                        {
                            errMessages = data.messages[err]; {{-- pass the error message to variable --}}
                            $('#' + err).parents('.form-group').addClass('has-error');
                            $('#'+ err + '-error').html('<code>' + errMessages + '</code>'); {{-- add error text to inputs --}}
                        }
                    }
                    else
                    {
                            alertify.success('' + data.messages + '');
                            swal("Success", data.messages, "success");
                            $('#form_inquiry')[0].reset();
                    }
                }
            });

        });
    </script>
@endsection
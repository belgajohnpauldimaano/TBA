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
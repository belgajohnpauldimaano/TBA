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
<h3 class="create-listing-title d-flex align-items-center d-lg-flex">
    <a href="\inbox">
        <span class="icon back"></span> Back to Inbox
    </a>
</h3>
@foreach ($messageDetails as $message)
    @foreach ($message[0] as $body)
        <div class="card" style="margin-bottom: 15px;">

            <div class="card-content">
                <div class="d-flex justify-content-between flex-column-reverse flex-md-row">
                    <div class="from-details d-flex align-items-center">
                        {{-- <div class="profile-pic">
                            <img src="assets/images/review1.png" alt="Dribble" style="display: none;">
                        </div> --}}
                        @if ($body['from_user_id'] == Auth()->user()->id)
                            @if (Auth()->user()->first_name == null)
                                {{ explode('@', Auth()->user()->email)[0] }}
                            @else
                                {{ Auth()->user()->first_name . ' ' . Auth()->user()->last_name }}
                            @endif
                        @elseif ($senderDetail[0]->first_name == null)
                            {{ explode('@', $senderDetail[0]->email)[0] }}
                        @else
                            {{ $senderDetail[0]->first_name . ' ' . $senderDetail[0]->last_name }}
                        @endif
                    </div>
                    <div class="inbox-option d-flex justify-content-between align-items-center ml-auto">
                        {{-- <a href=" # "><span class="icon reply "></span></a> --}}
                        {{-- <a href="# "><span class="icon trash "></span></a> --}}

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="readUnread"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="icon horizontal-options "></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="readUnread">
                                {{-- <a class="dropdown-item msg-reply" href="#">Reply</a> --}}
                                <a class="dropdown-item" href="#"
                                    onclick="blockUser('{{ $senderDetail[0]->id }}')">Block User</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="message-body">
                    <div class="subject">
                        <span
                            class="time">{{ date_format(new DateTime($body['created_at']), 'H:i A') }}</span>
                        <h1>{{ $body['subject'] }}</h1>
                        {!! $body['body_text'] !!}
                    </div>
                    <div class="attachments d-flex align-items-center justify-content-between">
                        <div class="separator m-0 w-100"></div>
                    </div>
                    <div class="file-types mt-3">
                        @if ($message[1] != null)
                            @foreach ($message[1] as $attach)
                                <a href="{{ '/download_file?generatedName=' . $attach->generated_file_name . '&fileName=' . $attach->file_name }}"
                                    class="d-flex align-items-center mb-2">
                                    <span class="icon attachment-download mr-3"></span> {{ $attach->file_name }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
<div class="card forward-reply-screen reply">
    <div class="card-content">
        <form action="" class="inbox-form">
            <div class="reply-to d-flex align-items-center">
                <span class="icon reply"></span>
                {{-- <div class="reply-to d-flex align-items-center"> --}}
                <p> {{ $senderDetail[0]->first_name . ' ' . $senderDetail[0]->last_name }}
                    ({{ $senderDetail[0]->email }})</p>
                <label id="errorSubmit errorMessage"></label>
                <input type="hidden" id="userMail" name="userMail" value='{{ $senderDetail[0]->email }}' />
                <input type="hidden" id="mailTo" name="mailTo" value='{{ $senderDetail[0]->id }}' />
                <input type="hidden" id="parentMailId" name="parentMailId"
                    value='{{ $messageDetails[0][0][0]->id }}' />
                <input type="hidden" id="subject" name="subject" value='' />
                {{-- <div class="inboxshare">
                            <span class="icon inbox-share"></span>
                        </div> --}}
            </div>
            <div style="margin:20px 0 10px;">
                <textarea class="details" name="message" id="message" style="width:100%;  border: 1px solid #d7e1f1;" rows="5"
                    value=""></textarea>
                <label id="lblError" class="errorMessage"></label>
            </div>
            <div class="message-footer border-0">
                <button class="btn btn-primary" type="submit" onclick="submitForm()" id="btnSubmit">Send</button>
                <div class="text-options">
                    <input name="attachment[]" type="file" multiple="multiple" id="attachment"
                        placeholder="Add Attachments" onchange="getFileNames(this)" style="display:none">
                    <a href="javascript:void(0)" onclick="$('#attachment').click()"><span
                            class="icon addAttachment"></span></a>
                    {{-- <a href="#" class="discardmessage ml-auto"><span class="icon discard"></span></a> --}}
                </div>
            </div>
        </form>
    </div>

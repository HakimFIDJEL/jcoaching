<div class="chatbox">
    <div class="chatbox-close"></div>
    <div class="custom-tab-1">

        {{-- Card Chatboxes --}}
        <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box border-primary border-left">
            {{-- Card Header --}}
            <div class="card-header chat-list-header text-center border-primary border-bottom">
                <a 
                    href="#" 
                    class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                    title="Marquer tous les messages comme lus"
                >
                    <i class="fa fa-inbox"></i>
                </a>
                <div>
                    <h6 class="mb-1">Chats</h6>
                    <p class="mb-0">
                        {{ now()->format('d/m/y') }}
                    </p>
                </div>
                <a 
                    href="javascript:void(0);" 
                    class="btn btn-outline-primary d-flex align-items-center justify-content-center" 
                    title="Fermer la fenêtre de chat"
                    id="close-chatbox"
                    onclick="$('.chatbox').removeClass('active');"
                >
                    <i class="fa fa-close"></i>
                </a>
            </div>
            {{-- /Card Header --}}

            {{-- Card Body --}}
            <div class="card-body contacts_body p-0 dz-scroll  " id="DZ_W_Contacts_Body">
                <ul class="contacts">
                    @php
                        $currentLetter = '';
                    @endphp
                
                    @foreach ($members_view->sortBy('lastname') as $member)
                        @php
                            $firstLetter = strtoupper(substr($member->lastname, 0, 1));
                        @endphp
                
                        @if ($firstLetter !== $currentLetter)
                            <li class="name-first-letter">{{ $firstLetter }}</li>
                            @php
                                $currentLetter = $firstLetter;
                            @endphp
                        @endif
                
                        <li class="dz-chat-user">
                            <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    @if($member->pfp_path)
                                        <img 
                                            src="{{ $member->getProfilePicture() }}" 
                                            class="rounded-circle user_img w-100 h-100 object-cover"
                                            alt=""
                                        />
                                    @else
                                        {{-- Two letters --}}
                                        <span class="rounded-circle user_img w-100 h-100 object-cover d-flex align-items-center justify-content-center bg-primary text-black">
                                            {{ strtoupper(substr($member->lastname, 0, 1)) }}{{ strtoupper(substr($member->firstname, 0, 1)) }}
                                        </span>

                                    @endif
                                </div>
                                <div class="user_info">
                                    <span>{{ $member->lastname }} {{ $member->firstname }}</span>
                                    <p>
                                        Message de test
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
            </div>
            {{-- /Card Body --}}
        </div>
        {{-- /Card Chatboxes --}}

        {{-- Chat History --}}
        <div class="card chat dz-chat-history-box d-none border-primary border-left">
            <div class="card-header chat-list-header text-center border-primary border-bottom">
                <a 
                    href="#" 
                    class="dz-chat-history-back btn btn-outline-primary d-flex align-items-center justify-content-center"
                    title="Retour à la liste des contacts"
                >
                    <i class="fa fa-arrow-left"></i>
                </a>
                <div>
                    <h6 class="mb-1">Chat with Khelesh</h6>
                    <p class="mb-0 text-success">Online</p>
                </div>							
                <div class="dropdown">
                    <a 
                        href="#" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false"
                        title="Options"
                        class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                    >
                        <i class="fa fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-item"><i class="fa fa-user-circle me-2"></i> View profile</li>
                        <li class="dropdown-item"><i class="fa fa-ban me-2"></i> Block</li>
                    </ul>
                </div>
            </div>
            <div class="card-body msg_card_body dz-scroll" id="DZ_W_Contacts_Body3">
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        Hi, how are you samim?
                        <span class="msg_time">8:40 AM, Today</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <div class="msg_cotainer_send">
                        Hi Khalid i am good tnx how about you?
                        <span class="msg_time_send">8:55 AM, Today</span>
                    </div>
                    <div class="img_cont_msg">
                <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        I am good too, thank you for your chat template
                        <span class="msg_time">9:00 AM, Today</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <div class="msg_cotainer_send">
                        You are welcome
                        <span class="msg_time_send">9:05 AM, Today</span>
                    </div>
                    <div class="img_cont_msg">
                <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        I am looking for your next templates
                        <span class="msg_time">9:07 AM, Today</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <div class="msg_cotainer_send">
                        Ok, thank you have a good day
                        <span class="msg_time_send">9:10 AM, Today</span>
                    </div>
                    <div class="img_cont_msg">
                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        Bye, see you
                        <span class="msg_time">9:12 AM, Today</span>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        Hi, how are you samim?
                        <span class="msg_time">8:40 AM, Today</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <div class="msg_cotainer_send">
                        Hi Khalid i am good tnx how about you?
                        <span class="msg_time_send">8:55 AM, Today</span>
                    </div>
                    <div class="img_cont_msg">
                <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        I am good too, thank you for your chat template
                        <span class="msg_time">9:00 AM, Today</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <div class="msg_cotainer_send">
                        You are welcome
                        <span class="msg_time_send">9:05 AM, Today</span>
                    </div>
                    <div class="img_cont_msg">
                <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        I am looking for your next templates
                        <span class="msg_time">9:07 AM, Today</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <div class="msg_cotainer_send">
                        Ok, thank you have a good day
                        <span class="msg_time_send">9:10 AM, Today</span>
                    </div>
                    <div class="img_cont_msg">
                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer">
                        Bye, see you
                        <span class="msg_time">9:12 AM, Today</span>
                    </div>
                </div>
            </div>
            <div class="card-footer type_msg">
                <div class="input-group">
                    <textarea class="form-control" placeholder="Type your message..."></textarea>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary align-items-center justify-content-center">
                            <i class="fa fa-location-arrow"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- /Chat History --}}
    </div>
</div>
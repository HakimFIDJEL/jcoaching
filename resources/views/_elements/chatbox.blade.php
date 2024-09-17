<div 
    class="chatbox active" 
    id="chatbox" 
    @if(Auth::user()->isAdmin())
        data-user-id=""
    @else
        data-user-id="{{ Auth::user()->id }}"
    @endif
    data-chatbox-messages-route="/admin/chatbox/show"
>
    <div class="chatbox-close"></div>
    <div class="custom-tab-1 ">

        @if(Auth::user()->isAdmin())
            {{-- Card Chatboxes --}}
            <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box border-primary border-left">
                {{-- Card Header --}}
                <div class="card-header chat-list-header text-center border-primary border-bottom">
                    <a 
                        href="#" 
                        class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                        title="Marquer tous les messages comme lus"
                        id="mark-as-read-chatbox"
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
                    
                            <li class="dz-chat-user" data-user-id="{{ $member->id }}">
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
        @endif

        {{-- Chat History --}}
        <div class="card chat dz-chat-history-box @if(Auth::user()->isAdmin()) d-none @endif border-primary border-left" style="height: 100vh">
            {{-- Card Header --}}
            <div class="card-header chat-list-header text-center border-primary border-bottom">
                <a 
                    href="#" 
                    class="dz-chat-history-back btn btn-outline-primary d-flex align-items-center justify-content-center"
                    @if(!Auth::user()->isAdmin()) 
                        id="close-chatbox" 
                        title="Fermer la fenêtre de chat"
                    @else
                        title="Retour à la liste des contacts"
                    @endif
                >
                    <i class="fa fa-arrow-left"></i>
                </a>
                <div>
                    <h6 class="mb-1 chatbox-user-name">
                        Chargement...
                    </h6>
                </div>							
                @if(Auth::user()->isAdmin()) 
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
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item ai-icon" href="javascript:void(0);" data-route="/admin/members/edit" title="Voir le profil" id="chatbox-view-profile">
                                <i class="fa fa-user-circle me-2"></i> 
                                <span>
                                    Voir le profil
                                </span>
                            </a>
                            <a class="dropdown-item ai-icon" href="javascript:void(0);" data-route="/admin/chatbox/block" title="Bloquer" id="chatbox-block">
                                <i class="fa fa-ban me-2"></i>
                                <span>
                                    Bloquer
                                </span>
                            </a>
                            <a class="dropdown-item ai-icon" href="javascript:void(0);" data-route="/admin/chatbox/unblock" title="Débloquer" id="chatbox-unblock">
                                <i class="fa fa-unlock me-2"></i>
                                <span>
                                    Débloquer
                                </span>
                            </a>
                            <a class="dropdown-item ai-icon" href="javascript:void(0);" data-route="/admin/chatbox/delete-messages" title="Supprimer les messages" id="chatbox-delete-messages">
                                <i class="fa fa-trash me-2"></i>
                                <span>
                                    Supprimer
                                </span>
                            </a>
                        </div>
                    </div>
                @else 
                    <div></div>
                @endif
            </div>
            {{-- /Card Header --}}

            {{-- Card Body --}}
            <div class="card-body msg_card_body dz-scroll chatbox-content" id="DZ_W_Contacts_Body3">
                
                <div class="chatbox-loading align-items-center justify-content-center w-100 h-100">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
                
                
            </div>
            {{-- /Card Body --}}

            {{-- Card Footer --}}
            <div class="card-footer type_msg" id="chatbox-form-container">
                <form method="POST" action="/admin/chatbox/send" enctype="multipart/form-data" id="chatbox-form">
                    @csrf

                    <div>
                        <input 
                            type="file" 
                            class="filepond" 
                            id="file" 
                            name="file" 
                            accept="image/*, video/*, application/pdf"
                            data-max-files="1"
                        >
                    </div>

                    <div class="input-group">
                        <textarea 
                            type="text" 
                            class="form-control @error('content') is-invalid @enderror" 
                            id="content" 
                            name="content" 
                            placeholder="Entrez votre message..." 
                            required
                        ></textarea>
                        <button 
                            type="submit" 
                            class="input-group-text btn btn-primary chatbox-send-button"
                            title="Envoyer le message"
                        >
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>

                </form>
            </div>
            {{-- /Card Footer --}}
        </div>
        {{-- /Chat History --}}
    </div>
</div>
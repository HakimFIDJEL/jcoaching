// Imports Chatbox
import moment from 'moment';
import clearAllFilePond from './filepond';
import swal from './swal';

// Imports Broadcast
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Variables
//  DOM
let chatbox = $("#chatbox");
let chatboxLoading = chatbox.find('.chatbox-loading');
let chatboxContent = chatbox.find('.chatbox-content');

let chatboxUserName = chatbox.find('.chatbox-user-name');
let chatboxSendButton = chatbox.find('.chatbox-send-button');
let chatboxFormContainer = chatbox.find('#chatbox-form-container');

let block_button = $('#chatbox-block');
let unblock_button = $('#chatbox-unblock');

let chatbox_send_button = chatbox.find('#chatbox-send-button');
let chatbox_loading_button = chatbox.find('#chatbox-loading-button');

let unread_messages_count = $('#unread-messages-count');

//  DATA
let chatboxAuthenticatedUserId = chatbox.data('authenticated-user-id');
let chatboxIsAdminstrator = chatbox.data('is-administrator');
let get_chatbox_messages_route = chatbox.data('chatbox-messages-route');
let chatbox_id = null;

let dayDiplayed;


$(document).ready(function() {

    moment.locale('fr');

    // Open Chatbox - DONE
    $(document).on('click', '#open-chatbox', function() {
        openChatbox();
    });

    // Close Chatbox - DONE
    $(document).on('click', '#close-chatbox', function() {
        closeChatbox();
    });

    // Minimize Chatbox - TODO
    $(document).on('click', '#mark-as-read-chatbox', function() {
        // 
    });

    // Open Chat - DONE
    $(document).on('click', '.dz-chat-user', function() {
        let userId = $(this).data('user-id');
        openChat(userId);
    });

    // Send Message - DONE
    $(document).on('submit', '#chatbox-form', function(e) {
        e.preventDefault();

        // Get the route
        let route = $(this).attr('action');
        route = route + '/' + chatbox.data('user-id');

        // Get the data
        let content = $(this).find('textarea[name="content"]').val();
        let file;

        let formData = new FormData();
        formData.append('content', content);
        let fileInput = $(this).find('input[name="file"]')[0];

        if(fileInput) {
            file = fileInput.files[0]; 
            if (file) {
                formData.append('file', file);
            }
        } else {
            formData.append('file', null);
        }

        // Send chat
        sendChat(route, formData);
    });

    // See profile - DONE
    $(document).on('click', '#chatbox-view-profile', function(e) {
        let userId = chatbox.data('user-id');
        let route = $(this).data('route');

        window.location.href = route + '/' + userId;
    });

    // Block user - DONE
    $(document).on('click', '#chatbox-block', function(e) {
        let userId = chatbox.data('user-id');
        let route = $(this).data('route');

        window.location.href = route + '/' + userId;
    });

    // UnBlock user - DONE
    $(document).on('click', '#chatbox-unblock', function(e) {
        let userId = chatbox.data('user-id');
        let route = $(this).data('route');

        window.location.href = route + '/' + userId;
    });
    
    // DELETE ALL MESSAGES - DONE
    $(document).on('click', '#chatbox-delete-messages', function(e) {
        let userId = chatbox.data('user-id');
        let route = $(this).data('route');
        let url = route + '/' + userId;

        swal.fire({
            title: 'Êtes-vous sûr(e) de vouloir supprimer tous les messages ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    configureBroadcast();

});


/** Fonctions primaires **/
function openChat(userId) {

    
    chatbox.data('user-id', userId);

    showLoading();

    // On récupère l'utilisateur, sa chatbox avec ses messages et les fichiers de ses messages
    $.ajax({
        url: get_chatbox_messages_route + '/' + userId,
        type: 'GET',
        success: function(response) {
            switch(response.status) {
                case 'success' : 
                    if(block_button.length) {
                        if(response.chatbox.blocked_at) {
                            block_button.hide();
                            unblock_button.show();
                        } else {
                            block_button.show();
                            unblock_button.hide();
                        }
                    }

                    chatbox_id = response.chatbox.id;

                    displayChat(response);
                    hideNotificationPoint(userId);
                    updateUnreadMessagesCount(response.chatbox.messages);
                break;
                case 'error' :
                    closeChatbox();
                    notyf.error(response.message ?? 'Une erreur est survenue !');
                    break;
                default:
                    closeChatbox();
                    notyf.error('Une erreur est survenue !');
                    break;
                }
            },
        error: function(response) {
            closeChatbox();
            notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
        }
    });
    
}

function sendChat(route, formData) {
    disableButton();

    $.ajax({
        url: route,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: formData,
        contentType: false,
        processData: false,
    })
    .done(function(response) {
        switch(response.status) {
            case 'success' :
                appendMessage(response.message, true);
                updateLastMessage(chatbox.data('user-id'), response.message.content);
                // autofocus
                chatboxFormContainer.find('textarea[name="content"]').focus();
            break;
            case 'error' :
                notyf.error('Une erreur est survenue !');
            break;
            default:
                notyf.error('Une erreur est survenue !');
            break;
        }
    })
    .fail(function(response) {
        if(response.responseJSON) {
            notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
        } else {
            notyf.error('Une erreur est survenue !');
        }
    })
    .always(function() {
        enableButton();
        clearTextarea();
        emptyFileInput();
        scrollToBottom();
    });
}
/** /Fonctions primaires **/


/** Fonctions secondaires **/
function createFileViewer(file) {

    let path = file.path.replace('public/', 'storage/');

    switch(file.type) {
        case 'image/png':
        case 'image/jpeg':
        case 'image/jpg':
            return `
            <a href="/${path}" target="_blank" title="Ouvrir l'image">
                <img src="/${path}" class="img-thumbnail" alt=""/>
            </a>
            `;
        break;
        case 'video/mp4':
            return `
            <video src="/${path}" class="img-thumbnail" controls title="Visualiser la vidéo"></video>
            `;
        break;
        case 'application/pdf':
            return `
            <a href="/${path}" target="_blank" class="btn btn-outline-secondary" title="Ouvrir le fichier PDF">
                <span>${file.filename}</span>
                <i class="fas fa-file-pdf fa-2x ml-2"></i>
            </a>
            `;
        break;
        default:
            return `
            <a href="/${path}" target="_blank" class="btn btn-outline-secondary" title="Télécharger le fichier">
                <span>${file.filename}</span>
                <i class="fas fa-file fa-2x ml-2"></i>
            </a>
            `;
        break;
    }
}

function appendDaySeparator(date) {

    // Si on a déjà affiché la date separatrice, on ne l'affiche pas
    if(dayDiplayed == moment(date).format('YYYY-MM-DD')) {
        return;
    } else {
        dayDiplayed = moment(date).format('YYYY-MM-DD');
    }

    chatboxContent.append( `
        <div class="d-flex justify-content-center mb-4 w-100">
            <div class="border-primary p-2 w-100 card text-center">
                ${moment(date).isSame(new Date(), 'day') ? 'Aujourd\'hui' : moment(date).format('D MMMM YYYY')}
            </div>
        </div>
    `);

    scrollToBottom();

    return;

}

function appendMessage(message, isMine) {


    // On affiche la date separatrice
    appendDaySeparator(message.created_at);

    let html = '';

    if(isMine) {
        html = `
            <div class="d-flex justify-content-end mb-4 chatbox-msg-right">
                <div class="msg_cotainer_send">
                    ${message.content}
                    <br>
                    ${message.file ? createFileViewer(message.file) : ''}
                <span class="msg_time_send">
                    ` + generateDate(message, isMine) + ` 
                </span>
            </div>
            <div class="img_cont_msg">
                ` + generateAvatar(message.user) + `
            </div>
        </div>
        `;
    } else {
        html = `
            <div class="d-flex justify-content-start mb-4 chatbox-msg-left">
                <div class="img_cont_msg">
                    ` + generateAvatar(message.user) + `
                </div>
                <div class="msg_cotainer">
                    ${message.content}
                    <br>
                    ${message.file ? createFileViewer(message.file) : ''}
                    <span class="msg_time">
                        ` + generateDate(message, isMine) + ` 
                       
                    </span>
                </div>
            </div>
        `;
        
    }
    

    chatboxContent.append(html);
}

function generateDate(message, isMine) {
    if(isMine) {
        return `${moment(message.created_at).format('HH:mm')} • ${message.read_at ? 'Lu le ' + moment(message.read_at).format('DD/MM/YY à HH:mm') + '<i class="fas fa-check ms-1"></i>' : 'Non lu <i class="fa fa-clock ms-1"></i>'}`;
    } else {
        return `${moment(message.created_at).format('HH:mm')} • Lu <i class="fas fa-check ms-1"></i>`;
    }
}

function generateAvatar(user) {
    if(user.pfp_path) {
        let path = user.pfp_path.replace('public/', 'storage/');
        return `<img src="/${path}" class="rounded-circle user_img_msg" alt=""/>`;
    } else {
        return `
            <span class="rounded-circle user_img w-100 h-100 object-cover d-flex align-items-center justify-content-center bg-primary text-black">
                ${user.firstname[0]}${user.lastname[0]}
            </span>
        `;
    }
}

function displayChat(response) {

    // Réinitialise la date affichée
    dayDiplayed = null;

    // Vide le contenu de la chatbox hormis le loading
    chatboxContent.children().not(chatboxLoading).remove();

    // Masque le chargement
    hideLoading();

    // Met à jour le nom d'utilisateur dans la chatbox
    chatboxUserName.text(response.chatbox.user.firstname + ' ' + response.chatbox.user.lastname);

    // Affiche les messages
    displayMessages(response.chatbox.messages);

    // Si l'utilisateur est bloqué, on affiche un message
    if(response.chatbox.blocked_at) {
        appendBlockMessage(response.chatbox.blocked_at);
        disableButton();
        hideFormContainer();
    } else {
        enableButton();
        showFormContainer();
    }

    // Scroll jusqu'en bas
    setTimeout(scrollToBottom, 0);
}

function displayMessages(messages) {
    messages.forEach(message => {
        appendMessage(message, message.user.id == chatboxAuthenticatedUserId);
    });
}
/** /Fonctions secondaires **/


/** Fonctions tertiaires **/
function openChatbox() {
    chatbox.addClass('active');

    if(!chatboxIsAdminstrator) {
        $(".dz-chat-history-box").removeClass('d-none');

        // On fait comme si on ouvrait la chatbox de l'utilisateur actuel
        openChat(chatboxAuthenticatedUserId);
    }

}

function closeChatbox() {
    chatbox.removeClass('active');
}

function showLoading() {
    chatboxContent.children().not(chatboxLoading).remove();
    chatboxLoading.css('display', 'flex');
    chatboxUserName.text('Chargement...');
    disableButton();
}

function hideLoading() {
    chatboxLoading.hide();
    enableButton();
}

function disableButton() {
    chatboxSendButton.prop('disabled', true);
    chatbox_send_button.css('display', 'none');
    chatbox_loading_button.css('display', 'block');
}

function enableButton() {
    chatboxSendButton.prop('disabled', false);
    chatbox_send_button.css('display', 'block');
    chatbox_loading_button.css('display', 'none');
}

function clearTextarea() {
    chatbox.find('textarea[name="content"]').val('');
}

function scrollToBottom() {
    setTimeout(() => {
        chatboxContent.scrollTop(chatboxContent.prop('scrollHeight'));
    }, 0);
}

function emptyFileInput() {
    clearAllFilePond();
}

function appendBlockMessage(date) {
    let html = `
        <div class="d-flex justify-content-center mb-4">
            <div class="alert alert-danger text-center">
                Conversation bloquée depuis le ${moment(date).format('DD/MM/YY à HH:mm')}.
            </div>
        </div>
    `;

    chatboxContent.append(html);
}

function hideFormContainer() {
    chatboxFormContainer.hide();
}

function showFormContainer() {
    chatboxFormContainer.show();
}

function updateLastMessage(userId, content) {
    let chatUser = $('.dz-chat-user[data-user-id="' + userId + '"]');
    let lastMessage = chatUser.find('.chatbox_last_message').first();
    lastMessage.text(content);
}

function updateUnreadMessagesCount(messages) {


    let nowReadMessages = messages.filter(message => !message.read_at && message.user.id != chatboxAuthenticatedUserId);
    let nowReadMessagesCount = nowReadMessages.length;
    let unreadMessagesCount = parseInt(unread_messages_count.text());
    unreadMessagesCount = unreadMessagesCount - nowReadMessagesCount;
    unread_messages_count.text(unreadMessagesCount);

    if(unreadMessagesCount == 0) {
        unread_messages_count.hide();
    }

}

function addUnreadMessagesCount() {
    let unreadMessagesCount = parseInt(unread_messages_count.text());
    unreadMessagesCount++;
    unread_messages_count.text(unreadMessagesCount);
    unread_messages_count.show();
}

function removeUnreadMessagesCount() {
    let unreadMessagesCount = parseInt(unread_messages_count.text());
    unreadMessagesCount--;
    unread_messages_count.text(unreadMessagesCount);

    if(unreadMessagesCount == 0) {
        unread_messages_count.hide();
    }
}

function showNotificationPoint(userId) {
    let chatUser = $('.dz-chat-user[data-user-id="' + userId + '"]');
    let notificationPoint = chatUser.find('.online_icon').first();
    if(notificationPoint.length > 0) {
        notificationPoint.show();
    }

}

function hideNotificationPoint(userId) {
    let chatUser = $('.dz-chat-user[data-user-id="' + userId + '"]');
    let notificationPoint = chatUser.find('.online_icon').first();
    if(notificationPoint.length > 0) {
        notificationPoint.hide();
    }
}
/** /Fonctions tertiaires **/



/** Fonctions de communication broadcast **/
function configureBroadcast() {
    window.Pusher = Pusher;
 
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: import.meta.env.VITE_REVERB_PORT,
        wssPort: import.meta.env.VITE_REVERB_PORT,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
    });


    if(chatboxIsAdminstrator) {
        window.Echo.private(`chatbox`)
        .listen('ChatboxMessageSent', (e) => {
            if(e.message.user_id != chatboxAuthenticatedUserId) {
                if(e.message.chatbox.user_id == chatbox.data('user-id')) {
                    appendMessage(e.message, false);
                    scrollToBottom();
                }
                addUnreadMessagesCount();
                showNotificationPoint(e.message.chatbox.user_id);
            }
            updateLastMessage(e.message.chatbox.user_id, e.message.content);
        });
    } else {

        window.Echo.private(`chatbox.${chatboxAuthenticatedUserId}`)
        .listen('ChatboxMessageSent', (e) => {
            if(e.message.user_id != chatboxAuthenticatedUserId) {
                appendMessage(e.message, false);
                updateLastMessage(e.message.chatbox.user_id, e.message.content);
                scrollToBottom();
                addUnreadMessagesCount();
            }
        });
    }

}
/** /Fonctions de communication broadcast **/


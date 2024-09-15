import moment from 'moment';

let chatbox = $("#chatbox");
let chatboxLoading = chatbox.find('.chatbox-loading');
let chatboxContent = chatbox.find('.chatbox-content');
let chatboxUserName = chatbox.find('.chatbox-user-name');
let chatboxSendButton = chatbox.find('.chatbox-send-button');

let get_chatbox_messages_route = chatbox.data('chatbox-messages-route');

$(document).ready(function() {

    // Close Chatbox - DONE
    $(document).on('click', '#close-chatbox', function() {
        closeChatbox();
    });

    // Minimize Chatbox - TODO
    $(document).on('click', '#mark-as-read-chatbox', function() {
        // 
    });

    // Open Chat - DOING
    $(document).on('click', '.dz-chat-user', function() {

        // On récupère l'utilisateur et on l'affiche comme l'utilisateur actuel
        let userId = $(this).data('user-id');

        // Si on a déjà chargé la chatbox de cet utilisateur, on l'affiche
        if(chatbox.data('user-id') == userId) {

        } else {
            chatbox.data('user-id', userId);
    
            showLoading();
    
            // On récupère l'utilisateur, sa chatbox avec ses messages et les fichiers de ses messages
            $.ajax({
                url: get_chatbox_messages_route + '/' + userId,
                type: 'GET',
                success: function(response) {
                    switch(response.status) {
                        case 'success' : 
                            displayChat(response);
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

    });

    // Send Message - DOING
    $(document).on('submit', '#chatbox-form', function(e) {
        e.preventDefault();

        let route = $(this).attr('action');
        route = route + '/' + chatbox.data('user-id');
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
                    appendAdminMessage(response.message);
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
        });
        
    });


});

function openChatbox() {
    chatbox.addClass('active');
}

function closeChatbox() {
    chatbox.removeClass('active');
}

function showLoading() {
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
}

function enableButton() {
    chatboxSendButton.prop('disabled', false);
}

function clearTextarea() {
    chatbox.find('textarea[name="content"]').val('');
}

function createFileViewer(file) {

    let path = file.path.replace('public/', 'storage/');

    switch(file.type) {
        case 'image/png':
        case 'image/jpeg':
        case 'image/jpg':
            return `
            <a href="${path}" target="_blank">
                <img src="${path}" class="img-thumbnail" alt=""/>
            </a>
            `;
        break;
        case 'video/mp4':
            return `
            <video src="${path}" class="img-thumbnail" controls></video>
            `;
        break;
        case 'application/pdf':
            
        break;
        default:

        break;
    }
}

function appendUserMessage(message) {
    let html = `
        <div class="d-flex justify-content-start mb-4">
            <div class="img_cont_msg">
                ` + generateAvatar(message.user) + `
            </div>
            <div class="msg_cotainer">
                ${message.content}
                <br>
                ${message.file ? createFileViewer(message.file) : ''}
                <span class="msg_time">
                    ${moment(message.created_at).format('dd/mm/yy - hh:mm A')}
                </span>
            </div>
        </div>
    `;

    chatboxContent.append(html);
}

function appendAdminMessage(message) {
    let html = `
        <div class="d-flex justify-content-end mb-4">
            <div class="msg_cotainer_send">
                ${message.content}
                <br>
                ${message.file ? createFileViewer(message.file) : ''}
            <span class="msg_time_send">
                ${moment(message.created_at).format('DD/MM/YY - hh:mm')}
            </span>
        </div>
        <div class="img_cont_msg">
            `
            + generateAvatar(message.user) +
            `
        </div>
    </div>
    `;

    chatboxContent.append(html);
}

function generateAvatar(user) {
    if(user.pfp_path) {
        let path = user.pfp_path.replace('public/', 'storage/');
        return `<img src="${path}" class="rounded-circle user_img_msg" alt=""/>`;
    } else {
        return `
            <span class="rounded-circle user_img w-100 h-100 object-cover d-flex align-items-center justify-content-center bg-primary text-black">
                ${user.firstname[0]}${user.lastname[0]}
            </span>
        `;
    }
}


function displayChat(response) {


    console.log(response);

    // Vide le contenu de la chatbox hormis le loading
    chatboxContent.children().not(chatboxLoading).remove();

    // Masque le chargement
    hideLoading();

    // Met à jour le nom d'utilisateur dans la chatbox
    chatboxUserName.text(response.chatbox.user.firstname + ' ' + response.chatbox.user.lastname);

    // Affiche les messages
    displayMessages(response.chatbox.messages);
}


function displayMessages(messages) {
    messages.forEach(message => {
        if(message.user.id == chatbox.data('user-id')) {
            appendUserMessage(message);
        } else {
            appendAdminMessage(message);
        }
    });
}
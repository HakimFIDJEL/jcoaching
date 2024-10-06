import{h as r}from"./moment-C5S46NFB.js";import{r as A,p as L,a as B,b as z,c as R,d as j,e as H}from"./filepond-plugin-pdf-preview-BwNPVfha.js";import"./jquery-CP0fMIbo.js";import{s as N}from"./swal-Bt6ici_8.js";import{P as O,E as J}from"./pusher-CycCXyy-.js";import"./_commonjsHelpers-Cpj98o6Y.js";import"./sweetalert2.all-B9kxGEux.js";A(L,B,z,R,j);const P=[];document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll('input[type="file"].filepond').forEach(t=>{const a=t.dataset.documents?JSON.parse(t.dataset.documents):[],o=H(t,{instantUpload:!1,server:{load:(s,u,de,ue,fe,he)=>{if(a.length>0){const _=a.find(Y=>Y.source===s);_&&u(_)}}},files:a,allowMultiple:t.dataset.maxFiles>1,maxFiles:t.dataset.maxFiles||1,storeAsFile:!0,labelIdle:'Déposez vos fichiers ou <span class="filepond--label-action"> Parcourir </span>',labelInvalidField:"Le champ contient des fichiers invalides",labelFileWaitingForSize:"En attente de taille",labelFileSizeNotAvailable:"Taille non disponible",labelFileLoading:"Chargement",labelFileLoadError:"Erreur pendant le chargement",labelFileProcessing:"Chargement",labelFileProcessingComplete:"Chargement terminé",labelFileProcessingAborted:"Chargement annulé",labelFileProcessingError:"Erreur pendant le chargement",labelFileProcessingRevertError:"Erreur pendant la restauration",labelFileRemoveError:"Erreur pendant la suppression",labelTapToCancel:"appuyez pour annuler",labelTapToRetry:"appuyez pour réessayer",labelTapToUndo:"appuyez pour annuler",labelButtonRemoveItem:"Supprimer",labelButtonAbortItemLoad:"Annuler",labelButtonRetryItemLoad:"Réessayer",labelButtonAbortItemProcessing:"Annuler",labelButtonUndoItemProcessing:"Annuler",labelButtonRetryItemProcessing:"Réessayer",labelButtonProcessItem:"Charger"});P.push(o)})});function q(){P.forEach(e=>{e.removeFiles()})}let n=$("#chatbox"),h=n.find(".chatbox-loading"),i=n.find(".chatbox-content"),D=n.find(".chatbox-user-name"),U=n.find(".chatbox-send-button"),x=n.find("#chatbox-form-container"),b=$("#chatbox-block"),y=$("#chatbox-unblock"),I=n.find("#chatbox-send-button"),T=n.find("#chatbox-loading-button"),l=$("#unread-messages-count"),c=n.data("authenticated-user-id"),E=n.data("is-administrator"),V=n.data("chatbox-messages-route"),p;$(document).ready(function(){r.locale("fr"),$(document).on("click","#open-chatbox",function(){Q()}),$(document).on("click","#close-chatbox",function(){f()}),$(document).on("click","#mark-as-read-chatbox",function(){}),$(document).on("click",".dz-chat-user",function(){let e=$(this).data("user-id");S(e)}),$(document).on("submit","#chatbox-form",function(e){e.preventDefault();let t=$(this).attr("action");t=t+"/"+n.data("user-id");let a=$(this).find('textarea[name="content"]').val(),o,s=new FormData;s.append("content",a);let u=$(this).find('input[name="file"]')[0];u?(o=u.files[0],o&&s.append("file",o)):s.append("file",null),G(t,s)}),$(document).on("click","#chatbox-view-profile",function(e){let t=n.data("user-id"),a=$(this).data("route");window.location.href=a+"/"+t}),$(document).on("click","#chatbox-block",function(e){let t=n.data("user-id"),a=$(this).data("route");window.location.href=a+"/"+t}),$(document).on("click","#chatbox-unblock",function(e){let t=n.data("user-id"),a=$(this).data("route");window.location.href=a+"/"+t}),$(document).on("click","#chatbox-delete-messages",function(e){let t=n.data("user-id"),o=$(this).data("route")+"/"+t;N.fire({title:"Êtes-vous sûr(e) de vouloir supprimer tous les messages ?",text:"Cette action est irréversible !",icon:"warning"}).then(s=>{s.isConfirmed&&(window.location.href=o)})}),ce()});function S(e){n.data("user-id",e),Z(),$.ajax({url:V+"/"+e,type:"GET",success:function(t){switch(t.status){case"success":b.length&&(t.chatbox.blocked_at?(b.hide(),y.show()):(b.show(),y.hide())),t.chatbox.id,W(t),le(e),re(t.chatbox.messages);break;case"error":f(),notyf.error(t.message??"Une erreur est survenue !");break;default:f(),notyf.error("Une erreur est survenue !");break}},error:function(t){f(),notyf.error(t.responseJSON.message??"Une erreur est survenue !")}})}function G(e,t){v(),$.ajax({url:e,type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},data:t,contentType:!1,processData:!1}).done(function(a){switch(a.status){case"success":m(a.message,!0),g(n.data("user-id"),a.message.content),x.find('textarea[name="content"]').focus();break;case"error":notyf.error("Une erreur est survenue !");break;default:notyf.error("Une erreur est survenue !");break}}).fail(function(a){a.responseJSON?notyf.error(a.responseJSON.message??"Une erreur est survenue !"):notyf.error("Une erreur est survenue !")}).always(function(){w(),te(),ae(),d()})}function k(e){let t=e.path.replace("public/","storage/");switch(e.type){case"image/png":case"image/jpeg":case"image/jpg":return`
            <a href="/${t}" target="_blank" title="Ouvrir l'image">
                <img src="/${t}" class="img-thumbnail" alt=""/>
            </a>
            `;case"video/mp4":return`
            <video src="/${t}" class="img-thumbnail" controls title="Visualiser la vidéo"></video>
            `;case"application/pdf":return`
            <a href="/${t}" target="_blank" class="btn btn-outline-secondary" title="Ouvrir le fichier PDF">
                <span>${e.filename}</span>
                <i class="fas fa-file-pdf fa-2x ml-2"></i>
            </a>
            `;default:return`
            <a href="/${t}" target="_blank" class="btn btn-outline-secondary" title="Télécharger le fichier">
                <span>${e.filename}</span>
                <i class="fas fa-file fa-2x ml-2"></i>
            </a>
            `}}function K(e){p!=r(e).format("YYYY-MM-DD")&&(p=r(e).format("YYYY-MM-DD"),i.append(`
        <div class="d-flex justify-content-center mb-4 w-100">
            <div class="border-primary p-2 w-100 card text-center">
                ${r(e).isSame(new Date,"day")?"Aujourd'hui":r(e).format("D MMMM YYYY")}
            </div>
        </div>
    `),d())}function m(e,t){K(e.created_at);let a="";t?a=`
            <div class="d-flex justify-content-end mb-4 chatbox-msg-right">
                <div class="msg_cotainer_send">
                    ${e.content}
                    <br>
                    ${e.file?k(e.file):""}
                <span class="msg_time_send">
                    `+C(e,t)+` 
                </span>
            </div>
            <div class="img_cont_msg">
                `+F(e.user)+`
            </div>
        </div>
        `:a=`
            <div class="d-flex justify-content-start mb-4 chatbox-msg-left">
                <div class="img_cont_msg">
                    `+F(e.user)+`
                </div>
                <div class="msg_cotainer">
                    ${e.content}
                    <br>
                    ${e.file?k(e.file):""}
                    <span class="msg_time">
                        `+C(e,t)+` 
                       
                    </span>
                </div>
            </div>
        `,i.append(a)}function C(e,t){return t?`${r(e.created_at).format("HH:mm")} • ${e.read_at?"Lu le "+r(e.read_at).format("DD/MM/YY à HH:mm")+'<i class="fas fa-check ms-1"></i>':'Non lu <i class="fa fa-clock ms-1"></i>'}`:`${r(e.created_at).format("HH:mm")} • Lu <i class="fas fa-check ms-1"></i>`}function F(e){return e.pfp_path?`<img src="/${e.pfp_path.replace("public/","storage/")}" class="rounded-circle user_img_msg" alt=""/>`:`
            <span class="rounded-circle user_img w-100 h-100 object-cover d-flex align-items-center justify-content-center bg-primary text-black">
                ${e.firstname[0]}${e.lastname[0]}
            </span>
        `}function W(e){p=null,i.children().not(h).remove(),ee(),D.text(e.chatbox.user.firstname+" "+e.chatbox.user.lastname),X(e.chatbox.messages),e.chatbox.blocked_at?(ne(e.chatbox.blocked_at),v(),oe()):(w(),se()),setTimeout(d,0)}function X(e){e.forEach(t=>{m(t,t.user.id==c)})}function Q(){n.addClass("active"),E||($(".dz-chat-history-box").removeClass("d-none"),S(c))}function f(){n.removeClass("active")}function Z(){i.children().not(h).remove(),h.css("display","flex"),D.text("Chargement..."),v()}function ee(){h.hide(),w()}function v(){U.prop("disabled",!0),I.css("display","none"),T.css("display","block")}function w(){U.prop("disabled",!1),I.css("display","block"),T.css("display","none")}function te(){n.find('textarea[name="content"]').val("")}function d(){setTimeout(()=>{i.scrollTop(i.prop("scrollHeight"))},0)}function ae(){q()}function ne(e){let t=`
        <div class="d-flex justify-content-center mb-4">
            <div class="alert alert-danger text-center">
                Conversation bloquée depuis le ${r(e).format("DD/MM/YY à HH:mm")}.
            </div>
        </div>
    `;i.append(t)}function oe(){x.hide()}function se(){x.show()}function g(e,t){$('.dz-chat-user[data-user-id="'+e+'"]').find(".chatbox_last_message").first().text(t)}function re(e){let a=e.filter(s=>!s.read_at&&s.user.id!=c).length,o=parseInt(l.text());o=o-a,l.text(o),o==0&&l.hide()}function M(){let e=parseInt(l.text());e++,l.text(e),l.show()}function ie(e){let a=$('.dz-chat-user[data-user-id="'+e+'"]').find(".online_icon").first();a.length>0&&a.show()}function le(e){let a=$('.dz-chat-user[data-user-id="'+e+'"]').find(".online_icon").first();a.length>0&&a.hide()}function ce(){window.Pusher=O,window.Echo=new J({broadcaster:"reverb",key:"wfsgwhoszdbwnudri09m",wsHost:"localhost",wsPort:"8080",wssPort:"8080",forceTLS:!1,enabledTransports:["ws","wss"]}),E?window.Echo.private("chatbox").listen("ChatboxMessageSent",e=>{e.message.user_id!=c&&(e.message.chatbox.user_id==n.data("user-id")&&(m(e.message,!1),d()),M(),ie(e.message.chatbox.user_id)),g(e.message.chatbox.user_id,e.message.content)}):window.Echo.private(`chatbox.${c}`).listen("ChatboxMessageSent",e=>{e.message.user_id!=c&&(m(e.message,!1),g(e.message.chatbox.user_id,e.message.content),d(),M())})}

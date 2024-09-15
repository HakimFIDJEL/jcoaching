import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin, { Draggable } from '@fullcalendar/interaction';
import moment from 'moment';

import swal from './swal';
import notyf from './notyf';


let fullcalendar_workouts_visible   = $("#calendar").data('fullcalendar_workouts_visible');
let fullcalendar_workouts_locked    = $("#calendar").data('fullcalendar_workouts_locked');
let fullcalendar_rest_periods       = $("#calendar").data('fullcalendar_rest_periods');

let updateWorkoutRoute              = $("#calendar").data('update_workout_route');
let updateRestPeriodRoute           = $("#calendar").data('update_rest_period_route');
let deleteRestPeriodRoute           = $("#calendar").data('delete_rest_period_route');
let isAdministrator                 = $("#calendar").data('is_administrator');
let userId                          = $("#calendar").data('user_id');

let draggableEls                    = document.querySelectorAll('.draggable');
let draggableContainer              = document.querySelector('.draggable-container');
let noDraggable                     = document.querySelector('.draggable-container .no-draggable');


document.addEventListener('DOMContentLoaded', function() {

    let workoutVisibleEvents = fullcalendar_workouts_visible.map(function(workout) {
        return {
            title: '#' + workout.id + ' - ' + workout.user.lastname + ' ' + workout.user.firstname,
            start: workout.date,
            userId: workout.user_id,
            workoutId: workout.id,
            type: 'workout',
            color: getWorkoutColour(workout.status, workout.date),
            className:  ''
        };
    });

    let workoutLockedEvents = fullcalendar_workouts_locked.map(function(workout) {
        return {
            title: '#' + workout.id,
            start: workout.date,
            userId: workout.user_id,
            workoutId: workout.id,
            type: 'workout',
            color: getWorkoutColour(workout.status, workout.date),
            className: 'fc-not-allowed-workout'
        };
    });

    let restPeriodEvents = fullcalendar_rest_periods.map(function(rest) {
        return {
            title: 'Période de repos',
            start: rest.start_date,
            end: rest.end_date, 
            id: rest.id,
            type: 'rest_period',
            color: 'var(--bs-danger)', 
            rendering: 'background', 
            className: !isAdministrator ? 'fc-not-allowed-rest-period' : '' 
        };
    });

    let events = workoutVisibleEvents.concat(workoutLockedEvents).concat(restPeriodEvents);

    // Draggable
    if (draggableEls && draggableEls.length > 0) {
        draggableEls.forEach(function(draggableEl) {
            new Draggable(draggableEl, {
                eventData: function(eventEl) {
                    return {
                        title: '#' + eventEl.dataset.workout + ' - ' + eventEl.dataset.title,
                        originalParent: eventEl.parentElement,
                        userId: eventEl.dataset.user,    
                        workoutId: eventEl.dataset.workout ,
                        type: 'workout',
                        color: 'var(--bs-secondary)',
                    };
                },
            });
        });
    }

    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ],
        headerToolbar: {
            start: 'prev,next today',
            center: 'title',
            end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialView: 'timeGridWeek',
        locale: 'fr',
        timeZone: 'Europe/Paris',

        businessHours: {
            daysOfWeek: [ 1, 2, 3, 4, 5, 6, 7],
            startTime: '10:00',
            endTime: '19:00',
        },

        allDaySlot: false,

        eventResizableFromStart: false,
        eventDurationEditable: false,

      

        editable: true,
        droppable: true,

        slotMinTime: '10:00',
        slotMaxTime: '19:00',

        events: events,

        eventOverlap: false,

        eventReceive: function(info) {


            swal.fire({
                title: 'Ajouter l\'entraînement ?',
                text: "Voulez-vous vraiment ajouter cet entraînement à votre planning ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                focusConfirm: true,
                focusCancel: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('Dropped !');
                    updateWorkout(info);
                } else {
                    console.log('Drop annulé !');
                    info.revert();
                }
            });
        },

        eventChange: function(info) {
            const oldStart = info.oldEvent.start;
            const newStart = info.event.start;
        
            const oldEnd = info.oldEvent.end;
            const newEnd = info.event.end;

            if (oldStart.getTime() !== newStart.getTime() || (oldEnd && newEnd && oldEnd.getTime() !== newEnd.getTime())) {
                if(info.event.extendedProps.type === 'rest_period') {
                    if(isAdministrator) {
                        swal.fire({
                            title: 'Modifier la période de repos ?',
                            text: "Voulez-vous vraiment modifier cette période de repos sur votre planning ?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non',
                            focusConfirm: true,
                            focusCancel: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                updateRestPeriod(info); // Appeler la fonction pour mettre à jour la période de repos
                            } else {
                                console.log('Changement annulé !');
                                info.revert(); // Revenir à l'état initial si annulé
                            }
                        });
                    } else {
                        notyf.error('Vous n\'êtes pas autorisé à modifier une période de repos !');
                        info.revert();
                    }
                } else {
                    swal.fire({
                        title: 'Modifier l\'entraînement ?',
                        text: "Voulez-vous vraiment modifier cet entraînement sur votre planning ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                        focusConfirm: true,
                        focusCancel: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updateWorkout(info); // Appeler la fonction pour mettre à jour l'entraînement
                        } else {
                            console.log('Changement annulé !');
                            info.revert(); // Revenir à l'état initial si annulé
                        }
                    });
                }
            } else {
                // Si ce n'est pas un changement de date, ne rien faire
            }
            
        
        },
        
        eventClick: function(info) {

            if(info.event.extendedProps.type === 'rest_period') {
                if(isAdministrator) {
                    swal.fire({
                        title: 'Supprimer la période de repos ?',
                        text: "Voulez-vous vraiment supprimer la période de repose de votre planning ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                        focusConfirm: true,
                        focusCancel: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('Event clicked !');
                            
                            deleteRestPeriod(info);
        
                        } else {
                            console.log('Click annulé !');
                        }
                    });
                } else {
                    notyf.error('Vous n\'êtes pas autorisé à supprimer une période de repos !');
                }
            } else {
                swal.fire({
                    title: 'Entraînement '+info.event.title,
                    text: "Voulez-vous vraiment retirer cet entraînement de votre planning ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    focusConfirm: true,
                    focusCancel: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('Event clicked !');
                        
                        removeWorkout(info);
    
                    } else {
                        console.log('Click annulé !');
                    }
                });
            }
            
            
        },        
    });
    
    calendar.render();
    
    let draggable = new Draggable(draggableEls);
});

// Affiche ou non le message "Aucun entraînement disponible"
function toggleNoDraggable() {
    let draggableElements = Array.from(draggableContainer.children).filter(function(child) {
        return child !== noDraggable;
    });


    if (draggableElements.length === 0) {
        noDraggable.style.display = 'flex';
    } else {
        noDraggable.style.display = 'none';
    }
}



// Ajouter un élément draggable dynamiquement dans son container d'origine
function addDraggableElement(info) {
    var event = info.event;
    
    // Créer un nouvel élément DOM
    var el = document.createElement('li');
    el.className = 'draggable list-group border border-primary p-2';
    el.style.borderRadius = '0';
    el.style.cursor = 'move';
    el.dataset.user = event.extendedProps.userId;
    el.dataset.workout = event.extendedProps.workoutId;
    el.dataset.title = event.title;
    el.innerHTML = "Séance " + event.title;
    
    // Ajouter l'élément au conteneur
    draggableContainer.appendChild(el);
    
    // Rendre l'élément draggable
    new Draggable(el, {
        eventData: {
            title: event.title,
            userId: event.extendedProps.userId,
            workoutId: event.extendedProps.workoutId
        },
    });
}

// Met à jour un entraînement dans la base de données
function updateWorkout(info) {
    let date = info.event.startStr;
    let gridMonth = false;
    if(date.length === 10) {
        date = date + 'T10:00:00';
        gridMonth = true;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        type: "POST",
        url: updateWorkoutRoute,
        data: {
            userId: info.event.extendedProps.userId,
            workoutId: info.event.extendedProps.workoutId,
            date: date
        },
        success: function (response) {
            if(gridMonth) {
                window.location.reload();
            }
            switch(response.status) {
                case 'success':
                    notyf.success(response.message);
                    if(info.draggedEl != undefined) {
                        info.draggedEl.remove();
                    }
                    updateWorkoutFromDatatable(response.workout);
                    console.log('Workout.status : ', response.workout.status);
                    console.log('Workout.date : ', response.workout.date);  
                    info.event.setProp('color', getWorkoutColour(response.workout.status, response.workout.date));
                    break;
                case 'error':
                    notyf.error(response.message ?? 'Une erreur est survenue !');
                    info.revert();
                    break;
                default:
                    notyf.error('Une erreur est survenue !');
                    info.revert();
                    break;
            }
        },
        error: function (response) {
            notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
            info.revert();
        }
    }).always(function() {
        toggleNoDraggable();
    });
}

// Retirer un entraînement du calendrier
function removeWorkout(info) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        type: "POST",
        url: updateWorkoutRoute,
        data: {
            userId: info.event.extendedProps.userId,
            workoutId: info.event.extendedProps.workoutId,
        },
        success: function (response) {
            switch(response.status) {
                case 'success':
                    notyf.success(response.message);
                    info.event.remove();  
                    addDraggableElement(info);  
                    updateWorkoutFromDatatable(response.workout);
                    break;
                case 'error':
                    notyf.error(response.message ?? 'Une erreur est survenue !');
                    break;
                default:
                    notyf.error('Une erreur est survenue !');
                    break;
            }
        },
        error: function (response) {
            console.log(response);
            notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
        }
    }).always(function() {
        toggleNoDraggable();
    });
}

// Met à jour une période de repos dans la base de données
function updateRestPeriod(info) {

    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        type: "POST",
        url: updateRestPeriodRoute,
        data: {
            rest_period : info.event.id,
            start_date: info.event.startStr,
            end_date: info.event.endStr,
        },
        success: function (response) {
            switch(response.status) {
                case 'success':
                    notyf.success(response.message);
                    break;
                case 'error':
                    notyf.error(response.message ?? 'Une erreur est survenue !');
                    info.revert();
                    break;
                default:
                    notyf.error('Une erreur est survenue !');
                    info.revert();
                    break;
            }
        },
        error: function (response) {
            notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
            info.revert();
        }
    });
}

// Supprime une période de repos de la base de données
function deleteRestPeriod(info) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        type: "POST",
        url: deleteRestPeriodRoute,
        data: {
            rest_period : info.event.id,
            start_date: info.event.startStr,
            end_date: info.event.endStr,
        },
        success: function (response) {
            switch(response.status) {
                case 'success':
                    notyf.success(response.message);
                    info.event.remove();
                    break;
                case 'error':
                    notyf.error(response.message ?? 'Une erreur est survenue !');
                    break;
                default:
                    notyf.error('Une erreur est survenue !');
                    break;
            }
        },
        error: function (response) {
            notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
        }
    });
}

// Retourne la couleur de l'entraînement en fonction de son statut
function getWorkoutColour(status, start_date) {
    // L'évènement est passé
    if(new Date(start_date) < new Date()) {
        if(status == 1) {
            return 'var(--bs-success)';
        } else {
            return 'var(--bs-warning)';
        }
    } else {
        return 'var(--bs-secondary)';
    }
}

/** Fonctions DataTable Primaires **/

// Fonction pour modifier un entraînement dans le tableau .datatable dynamiquement
function updateWorkoutFromDatatable(workout) {
    if ($('.datatable').length) {
        // Récupérer l'instance DataTable existante
        var table = $('.datatable').DataTable();

        var row = table.row('tr[data-workout-id="' + workout.id + '"]');

        if (row.length) {

            // Construire les nouvelles données de la ligne
            var rowData = [];

            // Colonne ID
            rowData.push('<strong>' + workout.id + '</strong>');

            // Colonne Statut
            rowData.push(getStatusCell(workout));

            // Colonne Membre (si l'utilisateur est administrateur)
            if (isAdministrator) {
                rowData.push(getMembreCell(workout));
            }

            // Colonne Obtention
            rowData.push(getObtentionCell(workout));

            // Colonne Date
            rowData.push(getDateCell(workout));

            // Colonne Actions (si l'utilisateur est administrateur)
            if (isAdministrator) {
                rowData.push(getActionsCell(workout));
            }

            // Mettre à jour la ligne dans le DataTable
            row.data(rowData).draw();
        } else {
            notyf.error('L\'entraînement #' + workout.id + ' n\'a pas été trouvé dans le tableau, veuillez recharger la page !');
        }


    } else {
        notyf.error('La table .datatable n\'existe pas !');
    }
}


/** Fonctions DataTable Secondaires **/

// Fonction pour générer le contenu de la cellule ID - DONE
function getIdCell(workout) {
    return '<span><strong>'+ workout.id +'</strong></span>';
}

// Fonction pour générer le contenu de la cellule Statut - DONE
function getStatusCell(workout) {
    if (workout.date) {
        if (workout.status == 1) {
            return '<span class="badge bg-success"><span>Faite</span><i class="fas fa-check ms-2"></i></span>';
        } else {
            return '<span class="badge bg-warning"><span>Non faite</span><i class="fas fa-close ms-2"></i></span>';
        }
    } else {
        return '<span class="badge bg-danger"><span>A planifier</span><i class="fas fa-exclamation-triangle ms-2"></i></span>';
    }
}

// Fonction pour générer le contenu de la cellule Membre - DONE
function getMembreCell(workout) {
    var url = '/admin/members/edit/' + workout.user.id; // Ajuster l'URL si nécessaire
    var name = workout.user.firstname + ' ' + workout.user.lastname;
    return '<a href="' + url + '" class="text-decoration-underline">' + name + '</a>';
}

// Fonction pour générer le contenu de la cellule Obtention - DONE
function getObtentionCell(workout) {
    if (workout.plan_id) {
        return '<span class="badge bg-primary">Abonnement</span>';
    } else {
        return '<span class="badge bg-secondary">A l\'unité</span>';
    }
}

// Fonction pour générer le contenu de la cellule Date - DONE
function getDateCell(workout) {
    if (workout.date) {
        // Utilisez moment.js pour formater la date (assurez-vous de l'inclure dans votre projet)
        var date = moment(workout.date).format('DD/MM/YY - HH:mm');
        return date;
    } else {
        return '<span class="badge bg-danger"><span>A planifier</span><i class="fas fa-exclamation-triangle ms-2"></i></span>';
    }
}

// Fonction pour générer le contenu de la cellule Actions - DONE
function getActionsCell(workout) {
    var buttons = '<div class="d-flex gap-2 align-items-center">';

    // Bouton Supprimer
    var deleteUrl = '/admin/calendar/workouts/soft-delete/' + workout.user.id + '/' + workout.id; // Ajuster l'URL si nécessaire
    buttons += '<a href="' + deleteUrl + '" class="btn btn-danger btn-sm warning-row" title="Supprimer la séance"><i class="fas fa-trash-alt"></i></a>';

    // Vérifier si la date est définie et passée
    if (workout.date && moment(workout.date).isBefore(moment())) {
        if (workout.status == 1) {
            // Bouton Marquer comme non faite
            var undoneUrl = '/admin/calendar/workouts/undone/' + workout.user.id + '/' + workout.id;
            buttons += '<a href="' + undoneUrl + '" class="btn btn-warning btn-sm" title="Marquer comme non faite"><i class="fas fa-undo"></i></a>';
        } else {
            // Bouton Marquer comme faite
            var doneUrl = '/admin/calendar/workouts/done/' + workout.user.id + '/' + workout.id;
            buttons += '<a href="' + doneUrl + '" class="btn btn-success btn-sm" title="Marquer comme faite"><i class="fas fa-check"></i></a>';
        }
    }

    buttons += '</div>';
    return buttons;
}

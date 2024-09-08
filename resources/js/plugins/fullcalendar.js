import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin, { Draggable } from '@fullcalendar/interaction';

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
                console.log('Changement sans modification de la date (ex: couleur).');
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
                        
                        refuseDate(info);
    
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

// Retirer un entraînement du calendrier
function refuseDate(info) {


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

            // update the event's color
            info.event.setProp('color', getWorkoutColour(response.workout.status, response.workout.date));
        },
        error: function (response) {
            notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
            info.revert();
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
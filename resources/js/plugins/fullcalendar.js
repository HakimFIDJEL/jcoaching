import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin, { Draggable } from '@fullcalendar/interaction';



document.addEventListener('DOMContentLoaded', function() {

    // Sélectionne tous les éléments avec la classe 'draggable'
    let draggableEls = document.querySelectorAll('.draggable');
    
    // Initialise Draggable pour chaque élément trouvé
    draggableEls.forEach(function(draggableEl) {
        new Draggable(draggableEl, {
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText.trim(),
                    originalParent: eventEl.parentElement,
                    // Ajouter d'autres propriétés si nécessaire
                };
            }
        });
    });

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
            daysOfWeek: [ 1, 2, 3, 4, 5, 6, 7 ],
            startTime: '10:00',
            endTime: '19:00',
        },

        editable: true,
        droppable: true,
        eventResizableFromStart: true,

        slotMinTime: '10:00',
        slotMaxTime: '19:00',

		  
       
    });


    calendar.render();

    let draggable = new Draggable(draggableEls);


   


});
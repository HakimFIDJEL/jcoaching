// public/js/charts.js

import Chart from 'chart.js/auto';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin, { Draggable } from '@fullcalendar/interaction';




document.addEventListener('DOMContentLoaded', () => {

    var calendarEl = document.getElementById('calendar');

    let events = window.workoutsData.map(function(workout) {
        return {
            title: '#' + workout.id + ' - ' + workout.user.lastname + ' ' + workout.user.firstname,
            start: workout.date,
            userId: workout.user_id,
            workoutId: workout.id,
            type: 'workout',
            className:  ''
        };
    });

    /** FULL CALENDAR **/
    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ],
       
        initialView: 'listWeek',
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

        slotMinTime: '10:00',
        slotMaxTime: '19:00',

        events: events,

        eventOverlap: false,
 
            
    });
    
    calendar.render();

});


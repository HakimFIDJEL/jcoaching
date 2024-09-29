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
       
        initialView: 'dayGridWeek',
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



    /** CHART JS **/

    // Fonction pour initialiser un graphique
    const initChart = (ctx, config) => {
        if (ctx) {
            new Chart(ctx, config);
        }
    };

    // 1. Graphique Annuel
    const yearCtx = document.getElementById('year-chart').getContext('2d');
    const yearConfig = {
        type: 'line', // ou 'line'
        data: {
            labels: window.yearChartData.months,
            datasets: [{
                label: 'Revenus (€)',
                data: window.yearChartData.revenues,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Montant (€)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Revenus Mensuels - ' + new Date().getFullYear()
                }
            }
        }
    };
    initChart(yearCtx, yearConfig);

    // 2. Graphique Mensuel
    const monthCtx = document.getElementById('month-chart').getContext('2d');
    const monthConfig = {
        type: 'line', // ou 'bar'
        data: {
            labels: window.monthChartData.days,
            datasets: [{
                label: 'Revenus (€)',
                data: window.monthChartData.revenues,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Montant (€)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Jour'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Revenus Quotidiens - ' + new Date().toLocaleString('fr-FR', { month: 'long', year: 'numeric' })
                }
            }
        }
    };
    initChart(monthCtx, monthConfig);

    // 3. Graphique Hebdomadaire
    const weekCtx = document.getElementById('week-chart').getContext('2d');
    const weekConfig = {
        type: 'line', // ou 'line'
        data: {
            labels: window.weekChartData.days,
            datasets: [{
                label: 'Revenus (€)',
                data: window.weekChartData.revenues,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Montant (€)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Jour de la Semaine'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Revenus Quotidiens - Cette Semaine'
                }
            }
        }
    };
    initChart(weekCtx, weekConfig);
});


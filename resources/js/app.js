import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar')

    if (!calendarEl) return

    let calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',

        events: window.calendarEvents ?? [],

        eventColor: '#3788d8',

        eventClick: function(info) {
            alert(info.event.title)
        }
    })

    calendar.render()
})
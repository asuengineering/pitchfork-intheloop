/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./src/scripts/fullcalendar-init.js ***!
  \******************************************/
// Initialize Fullcalendar.io
document.addEventListener('DOMContentLoaded', function () {
  console.log(CALDATA.events);
  var events = CALDATA.events;
  var calendarEl = document.getElementById('calendar');
  function mobileCheck() {
    if (window.innerWidth >= 768) {
      return false;
    } else {
      return true;
    }
  }
  ;
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: mobileCheck() ? 'listMonth' : 'dayGridMonth',
    height: 'auto',
    events: events,
    nextDayThreshold: '03:00:00',
    eventColor: '#ffc627',
    eventTextColor: '#191919',
    navLinks: false,
    headerToolbar: {
      start: 'title',
      end: 'today prev,next dayGridMonth,listMonth'
    },
    buttonText: {
      today: 'Today',
      month: 'Month',
      list: 'List'
    },
    dayHeaderFormat: {
      weekday: 'long'
    },
    windowResize: function (view) {
      if (window.innerWidth >= 768) {
        calendar.changeView('dayGridMonth');
      } else {
        calendar.changeView('listMonth');
      }
    },
    eventClick: function (info) {
      info.jsEvent.preventDefault(); // keep from opening a new window.
      info.el.focus();

      // If click is done within mobile, just go to the post.
      if (window.innerWidth <= 768) {
        window.location.href = info.event.url;
        return;
      }

      // console.log(info.event);
      // console.log(info.event.extendedProps);

      let eventPreview = document.querySelector('#event-preview');
      let newEvent = document.createElement('div');
      newEvent.id = 'event-preview';

      // Agenda string
      let agendaStr = '';
      if (info.event.extendedProps.agenda) {
        agendaStr = '<p>' + info.event.extendedProps.agenda + '</p>';
      }

      // CTA Link
      let ctaLink = '';
      if (info.event.extendedProps.cta_link) {
        let ctaInfo = info.event.extendedProps.cta_link;
        ctaLink = '<p>Additional info: <a href="' + ctaInfo.url + '" target="' + ctaInfo.target + '">' + ctaInfo.title + '</a></p>';
      }

      // Location string
      let locationString = '';
      if (info.event.extendedProps.location) {
        let location = info.event.extendedProps.location;
        locationString = '<p><span class="fas fa-map-marker-alt"></span>';
        if (info.event.extendedProps.map_link) {
          let mapLink = info.event.extendedProps.map_link;
          locationString += '<a href="' + mapLink + '">' + location + '</a></p>';
        } else {
          locationString += location + '</p>';
        }
      }

      // Post Title 
      let postTitle = '<div class="post-title"><h3><a href="' + info.event.url + '">' + info.event.extendedProps.post_title + '</a></h3></div>';

      // Add to Outlook calendar link
      let addOutlook = '';
      if (info.event.extendedProps.outlook_cal_link) {
        addOutlook = '<a class="cal-link" href="' + info.event.extendedProps.outlook_cal_link + '">Add to Outlook</a>';
      }
      ;

      // Add to Google calendar link
      let addGoogle = '';
      if (info.event.extendedProps.google_cal_link) {
        addGoogle = '<a class="cal-link" href="' + info.event.extendedProps.google_cal_link + '">Add to Google</a>';
      }

      // Date string formatting depending on the event type.
      let startStr = '';
      let endStr = '';
      let dateFormatFull = {
        dateStyle: 'long',
        timeStyle: 'short'
      };
      let dateFormatDay = {
        dateStyle: 'long'
      };
      let dateFormatTime = {
        timeStyle: 'short'
      };

      // console.log('Event type: ' + info.event.extendedProps.date_string);

      switch (info.event.extendedProps.date_string) {
        case 'dates':
          // Marked as all day on the calendar. May span multple days.
          // Check for an end date first, change label for start date accordingly.
          if (info.event.end) {
            startStr = '<p><span class="far fa-calendar"></span>Start: ';
            endStr = '<p><span class="far fa-calendar"></span>End: ' + info.event.end.toLocaleDateString('en-us', dateFormatDay) + '</p>';
          } else {
            // No end date, so no need for the "start" label.
            startStr = '<p><span class="far fa-calendar"></span>';
          }
          startStr += info.event.start.toLocaleDateString('en-us', dateFormatDay) + '</p>';
          break;
        case 'deadline':
          // Assumes a start date & time, all day and no end date displayed. 
          startStr = '<p><span class="far fa-alarm-clock"></span>' + info.event.start.toLocaleDateString('en-us', dateFormatDay) + ' by ' + info.event.start.toLocaleTimeString('en-us', dateFormatTime);
          '</p>';
          break;
        case 'agenda':
          startStr = '<p><span class="far fa-calendar"></span>' + info.event.start.toLocaleDateString('en-us', dateFormatDay) + '</p>';
          break;
        case 'standard':
        default:
          // Check to see if the start date and end date are the same.
          const datesAreOnSameDay = (first, second) => first.getFullYear() === second.getFullYear() && first.getMonth() === second.getMonth() && first.getDate() === second.getDate();
          if (datesAreOnSameDay(info.event.start, info.event.end)) {
            startStr = '<p><span class="far fa-calendar"></span>' + info.event.start.toLocaleDateString('en-us', dateFormatDay) + '</p>';
            endStr = '<p><span class="far fa-clock"></span>' + info.event.start.toLocaleTimeString('en-us', dateFormatTime) + ' to ' + info.event.end.toLocaleTimeString('en-us', dateFormatTime) + '</p>';
          } else {
            startStr = '<p><span class="far fa-calendar"></span>Start: ' + info.event.start.toLocaleString('en-us', dateFormatFull) + '</p>';
            endStr = '<p><span class="far fa-calendar"></span>End: ' + info.event.end.toLocaleString('en-us', dateFormatFull) + '</p>';
          }
          break;
      }
      newEvent.innerHTML = postTitle + '<div class="event-details">' + '<h4>' + info.event.title + '</h4>' + '<p>' + info.event.extendedProps.description + '</p>' + startStr + endStr + agendaStr + locationString + ctaLink + addOutlook + addGoogle + '</div>';
      eventPreview.replaceWith(newEvent);
    }
  });
  calendar.render();
});
/******/ })()
;
//# sourceMappingURL=fullcalendar-init.js.map
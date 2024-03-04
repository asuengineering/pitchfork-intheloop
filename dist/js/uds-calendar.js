/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./src/scripts/uds-calendar.js ***!
  \*************************************/
document.addEventListener('DOMContentLoaded', function () {
  let calendarDates = Object.values(CALDATA.events);
  initCalendar(calendarDates);
});
function initCalendar(dateArray) {
  const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  const desktopDaysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  const mobileDaysOfWeek = ['Su', 'M', 'Tu', 'W', 'Th', 'F', 'Sa'];
  const gridsize = 42;
  const oldestDate = dateArray.reduce((c, n) => Date.parse(n) < Date.parse(c) ? n : c);
  const state = {
    month: new Date(oldestDate).getMonth(),
    year: new Date(oldestDate).getFullYear()
  };
  const datesForGrid = (year, month) => {
    const today = new Date();
    const dates = [];
    const firstDay = new Date(year, month).getDay();
    const totalDaysInMonth = new Date(year, month + 1, 0).getDate();
    const totalDaysInPrevMonth = new Date(year, month, 0).getDate();

    // Loop through dateArray, remove all dates that are not in the displayed month.
    // Create array of numbers indicating day of the month. (12/31/2021 = 31)
    // Later, if i is in this array, add today class. 
    var currentMonthDates = [];
    dateArray.forEach(function (item, index) {
      checkDate = new Date(item);
      if (checkDate.getMonth() == state.month) {
        currentMonthDates.push(checkDate.getDate());
      }
    });

    // console.log(dateArray);
    // console.log(currentMonthDates);

    // Days from prev month to show in the grid
    for (let i = 1; i <= firstDay; i++) {
      const prevMonthDate = totalDaysInPrevMonth - firstDay + i;
      const key = new Date(state.year, state.month - 1, prevMonthDate).toLocaleString();
      dates.push({
        key: key,
        date: prevMonthDate,
        monthClass: 'prev'
      });
    }

    // Days of the current month to show in the grid
    for (let i = 1; i <= totalDaysInMonth; i++) {
      const key = new Date(state.year, state.month, i).toLocaleString();
      if (currentMonthDates.includes(i)) {
        dates.push({
          key: key,
          date: i,
          monthClass: 'current',
          todayClass: 'today'
        });
      } else {
        dates.push({
          key: key,
          date: i,
          monthClass: 'current'
        });
      }
    }

    // If there is space left over in the grid, then show the dates for the next month
    if (dates.length < gridsize) {
      const count = gridsize - dates.length;
      for (let i = 1; i <= count; i++) {
        const key = new Date(state.year, state.month + 1, i).toLocaleString();
        dates.push({
          key: key,
          date: i,
          monthClass: 'next'
        });
      }
    }
    return dates;
  };
  const render = () => {
    const calendarContainer = document.getElementById('calendar');
    calendarContainer.innerHTML = `
        <h4><span class="highlight-black">${months[state.month]} ${state.year}</span></h4>
        <div class="calendar-grid">
          <div class="heading desktop">
            ${desktopDaysOfWeek.map(day => `<p>${day}</p>`).join('')}
          </div>
          <div class="heading mobile">
            ${mobileDaysOfWeek.map(day => `<p>${day}</p>`).join('')}
          </div>
          <div class="body">
            ${datesForGrid(state.year, state.month).map(date => `<h3 id="${date.key}" class="calendar-item ${date.monthClass}" ${date.todayClass ? `aria-label="${date.todayClass[0].toUpperCase()}${date.todayClass.slice(1)}"` : ''}>
                    <span class="${date.todayClass ? date.todayClass : ''}">${date.date}</span>
                  </h3>`).join('')}
          </div>
        </div>
        <div class="calendar-nav">
          <button id="prev-month" aria-label="Previous month"><span class="fas fa-angle-left"></span></button>
          <button id="next-month" aria-label="Next month"><span class="fas fa-angle-right"></span></button>
        </div>
    `;
  };
  const showCalendar = monthIndicator => {
    var date = new Date(state.year, state.month + monthIndicator);
    state.year = date.getFullYear();
    state.month = date.getMonth();
    render();
  };
  document.addEventListener('click', ev => {
    if (ev.target.id === 'prev-month') {
      showCalendar(-1);
    }
    if (ev.target.id === 'next-month') {
      showCalendar(1);
    }
  });
  showCalendar(0);
}
;
/******/ })()
;
//# sourceMappingURL=uds-calendar.js.map
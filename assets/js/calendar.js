const currentMonthElement = document.getElementById('currentMonth');
const calendarBody = document.getElementById('calendarBody');
const prevMonthButton = document.getElementById('prevMonth');
const nextMonthButton = document.getElementById('nextMonth');

const today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();

function updateCalendar() {
    currentMonthElement.textContent = new Date(currentYear, currentMonth, 1).toLocaleString('default', { month: 'long', year: 'numeric' });
    calendarBody.innerHTML = '';

    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);

    let day = new Date(firstDay);

    while (day.getDay() !== 1) {
        day.setDate(day.getDate() - 1);
    }

    while (day <= lastDay) {
        const weekRow = document.createElement('tr');
        for (let i = 0; i < 7; i++) {
            const cell = document.createElement('td');
            cell.textContent = day.getDate();

            if (day.getMonth() !== currentMonth) {
                cell.className = 'other-month';
            } else if (day.getDay() === 0 || day.getDay() === 6) {
                cell.className = 'weekend';
            }

            weekRow.appendChild(cell);
            day.setDate(day.getDate() + 1);
        }
        calendarBody.appendChild(weekRow);
    }
}

prevMonthButton.addEventListener('click', () => {
    currentMonth -= 1;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear -= 1;
    }
    updateCalendar();
});

nextMonthButton.addEventListener('click', () => {
    currentMonth += 1;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear += 1;
    }
    updateCalendar();
});

updateCalendar();

function formatDateInRussian() {
    const months = [
        'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
        'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
    ];

    const daysOfWeek = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];

    const date = new Date();
    const day = date.getDate();
    const month = date.getMonth();
    const dayOfWeek = date.getDay();

    const formattedDate = `${day} ${months[month]}, ${daysOfWeek[dayOfWeek]}`;

    document.querySelector('.date').innerText = formattedDate;
}

formatDateInRussian();
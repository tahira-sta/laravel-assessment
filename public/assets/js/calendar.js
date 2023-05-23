
'use strict';


var cal = new tui.Calendar('#calendar', {
    
    defaultView: 'month',
    useCreationPopup: false,
    useDetailPopup: false,
    taskView: true,
    isReadOnly: true,
    useDetailPopup: true
    // template: {
    //     monthDayname: function(dayname) {
    //         return '<span class="calendar-week-dayname-name">' + dayname.label + '</span>';
    //     },
    // }
});

$('#preCal').on('click', function() {
    cal.prev();
    setRenderRangeText();
});
$('#nextCal').on('click', function() {
    cal.next();
    setRenderRangeText();
});

$('#today').on('click', function() {
    cal.today();
    setRenderRangeText();
});
cal.setTheme({
    'month.dayname.height': '31px',
    'month.dayname.fontSize': '15px',
    'month.dayname.borderBottom': '1px solid #4365CA', // Not valid key  will be return.
    // 'common.dayname.color': '#333',
    'common.dayname.fontSize': '13px',
});

    setRenderRangeText();


// cal.createSchedules([{
//         id: '1',
//         calendarId: '1',
//         title: 'my schedule',
//         category: 'time',
//         dueDateClass: '',
//         start: '2021-01-18T22:30:00+09:00',
//         end: '2021-01-19T02:30:00+09:00'
//     },
//     {
//         id: '2',
//         calendarId: '1',
//         title: 'Present',
//         category: 'time',
//         dueDateClass: '',
//         start: '2021-01-18T17:30:00+09:00',
//         end: '2021-01-18T17:31:00+09:00',
//         // isReadOnly: true // schedule is read-only
//     },
//     {
//         id: '489273',
//         title: 'Present',
//         isAllDay: true,
//         start: '2021-01-19T17:30:00+09:00',
//         start: '2021-01-19T17:30:00+09:00',
//         color: '#ffffff',
//         isVisible: true,
//         bgColor: '#69BB2D',
//         dragBgColor: '#69BB2D',
//         borderColor: '#69BB2D',
//         calendarId: '1',
//         category: 'allday',
//         dueDateClass: '',
//         customStyle: 'cursor: default;',
//         isPending: false,
//         isFocused: false,
//         isReadOnly: true,
//         isPrivate: false,
//         location: '',
//         attendees: '',
//         recurrenceRule: '',
//         state: ''
//     },
// ]);

function setRenderRangeText() {
    var renderRange = document.getElementById('renderRange');
    var options = cal.getOptions();
    var viewName = cal.getViewName();
    var html = [];

    if (viewName === 'day') {
        html.push(moment(cal.getDate().getTime()).format('MMM YYYY DD'));
    } else if (viewName === 'month' &&
        (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
        html.push(moment(cal.getDate().getTime()).format('MMM YYYY'));
    } 
    console.log(moment(cal.getDate().getTime()).format('MMM YYYY DD'));
    renderRange.innerHTML = html.join('');
    
}
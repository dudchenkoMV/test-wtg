<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Test task') }}</title>

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fullcalendar/main.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body>
    @yield('body')

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar/main.js') }}"></script>

    <script>
        $(function () {

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()), // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex        : 1070,
                        revert        : true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),

                    };
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'title',
                    right : 'prev,next today'
                },
                locale: 'ua',
                allDaySlot: false,
                initialView: 'timeGridWeek',
                themeSystem: 'bootstrap',
                events: 'events/ajax',
                editable  : true,
                eventDrop: function (info) {
                    var event = info.event;
                    var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    var end = moment(event.end).format('YYYY-MM-DD HH:mm:ss')
                    $.ajax({
                        url: 'events/' + event.id + '/update',
                        type: "POST",
                        data: {
                            id: event.id,
                            title: event.title,
                            start_at: start,
                            end_at: end,
                        },
                        success: function (response) {

                        }
                    });
                },
                eventResize: function (info) {
                    var event = info.event;
                    var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    var end = moment(event.end).format('YYYY-MM-DD HH:mm:ss')
                    $.ajax({
                        url: 'events/' + event.id + '/update',
                        type: "POST",
                        data: {
                            id: event.id,
                            title: event.title,
                            start_at: start,
                            end_at: end,
                        },
                        success: function (response) {

                        }
                    });
                },
                eventReceive: function (info) {
                    var event = info.event;
                    var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    var end = moment(event.start).add(1, 'hours').format('YYYY-MM-DD HH:mm:ss');
                    $.ajax({
                        url: 'events/store',
                        type: "POST",
                        data: {
                            title: event.title,
                            start_at: start,
                            end_at: end,
                        },
                        success: function (response) {
                            event.remove();
                            calendar.refetchEvents();
                        }
                    });
                },
                eventClick: function (info) {
                    var event = info.event;
                    $.ajax({
                        url: 'events/' + event.id + '/destroy',
                        type: "POST",
                        data: {
                            id: event.id,
                        },
                        success: function (response) {
                            event.remove();
                        }
                    });
                }

            });

            calendar.render();

            /* ADDING EVENTS */
            var currColor = '#3c8dbc' //Red by default
            // Color chooser button
            $('#color-chooser > li > a').click(function (e) {
                e.preventDefault()
                // Save color
                currColor = $(this).css('color')
                // Add color effect to button
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color'    : currColor
                })
            })
            $('#add-new-event').click(function (e) {
                e.preventDefault()
                // Get value and make sure it is not null
                var val = $('#new-event').val()
                if (val.length == 0) {
                    return
                }

                // Create events
                var event = $('<div />')
                event.css({
                    'background-color': currColor,
                    'border-color'    : currColor,
                    'color'           : '#fff'
                }).addClass('external-event')
                event.text(val)
                $('#external-events').prepend(event)

                // Add draggable funtionality
                ini_events(event)

                // Remove event from text input
                $('#new-event').val('')
            })
        })
    </script>
</body>
</html>

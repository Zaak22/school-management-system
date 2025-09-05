var base_url = $("#base_url").val();

$(document).ready(function(){
    $("#topNavDashboard").addClass('active');

    $('#calendar').fullCalendar({
        events: {
            url: base_url + 'dashboard/getStudentDailySummery',
            type: 'POST',
            data: function() {
                return {
                    class_id: $('.class-filter').val()
                };
            }
        },
        eventRender: function(event, element) {
            element.find('.fc-title').remove();
            element.css({
                "background": "white",
                "border": "none",
                "box-shadow": "none",
                "padding": "4px"
            });

            var present = parseInt(event.present, 10) || 0;
            var absent  = parseInt(event.absent, 10) || 0;
            var late    = parseInt(event.late, 10) || 0;

            var maxVal = Math.max(present, absent, late);
            if (maxVal === 0) return;

            var barContainer = $('<div style="display:flex; justify-content:center; gap:6px; margin:4px auto; text-align:center;"></div>');

            function createBar(value, max, color, label, title) {
                var percent = (value / max * 100) || 0;

                var wrapper = $('<div style="width:16px; display:flex; flex-direction:column; align-items:center; font-size:11px; color:#333;"></div>');
                var barArea = $('<div style="height:40px; display:flex; align-items:flex-end; width:100%;"></div>');
                var bar = $('<div style="width:100%; height:'+percent+'%; background:'+color+'; border-radius:3px;" title="'+title+'"></div>');

                barArea.append(bar);
                wrapper.append(barArea);
                wrapper.append('<div style="color:'+color+'; font-weight:bold;">'+label+'</div>');

                return wrapper;
            }

            barContainer.append(createBar(present, maxVal, '#28a745', 'P', 'Present: '+present+' student'+(present > 1 ? 's' : '')));
            barContainer.append(createBar(absent,  maxVal, '#dc3545', 'A', 'Absent: '+absent+' student'+(absent > 1 ? 's' : '')));
            barContainer.append(createBar(late,    maxVal, '#ffc107', 'L', 'Late: '+late+' student'+(late > 1 ? 's' : '')));

            element.append(barContainer);
        }
    });

    $('.class-filter').on('change', function() {
        $('#calendar').fullCalendar('refetchEvents');
    });
});

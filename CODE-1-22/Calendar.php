<?php
  include('db_conn2.php');
  $query = $conn->query("SELECT * FROM sarf_requests ORDER BY id");

  if (!$query) {
      die("Query failed: " . $conn->error);
  }
  ?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="Calendar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
 <body>
 <h2 align="center"></a></h2><br>
 <div class="split-background">
    <br />
    <br />
    <div class="Content">
    <div id="calendar" style="max-height: 400px; width: 80%; margin: 0 auto;"></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                    header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,agendaWeek'
                  },
              events: 'events.php',
              eventRender: function(event, element) {
              element.find('.fc-title').append('<br/>' + event.start.format('HH:mm:ss'))
              element.find('.fc-time').remove();
              }

            });
        });
    </script>
    <style>
        .event-marker {
            font-size: 10px;
            color: yellow;
        }
    </style>
	</div>
</body>
</html>

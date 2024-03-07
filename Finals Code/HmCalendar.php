<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="CSS/dircalendar.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  


  <?php
  include('db_conn2.php');
  $query = $conn->query("SELECT * FROM sarf_requests ORDER BY id");

  if (!$query) {
      die("Query failed: " . $conn->error);
  }
  ?>

  <style>

    .legend {
      padding: 10px;
      background-color: white;
      border: 1px solid #ddd;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 190px;
      height: 110px;
    }

    .legend-item {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
    }

    .legend-marker {
      width: 20px;
      height: 20px;
      margin-right: 10px;
      border: 1px solid #ddd;
    }
    #calendar {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    margin-top: 10px;
    margin-left: 200px;
  }

  @media screen and (max-width: 768px) {


    #calendar {
      max-width: 100%;
      
    }
  }
  #calendar .fc-event {
    border-radius: 10px; 
    font-family: sans-serif;
  }
  .fc-content {
      text-align: center;
      font-family: sans-serif;
      font-weight: 500;
    }


    .container{
      display: flex;
      flex-direction: column;
      padding-right: 10%;
    }
    .upper{
      display: flex;
      padding-right: 8%;
      padding-top: 2px;
      justify-content: flex-end;

    }

  </style>
</head>
<body>
  <div class="split-background">
    <div class="left">
    <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
               
            <button class="btnNavbar" onclick="goHmHome()"> 
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadHmPageContent('HmStatus')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadHmPageContent('HmApproval')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>
            
            <button class="btnNavbar" onclick="goToHmCalendar()">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
 
            <div class="outterline">
            <div class="line"></div>
            <div class="buttons">
        <button class="profilebtn"><img src="IMG/profile.png" alt=""></button>

        <button id="logoutbtn" class="lgoutbtn"><img src="IMG/exit.png"></button>
        </div>
            </div>

        <script>
        var button = document.getElementById("logoutbtn");
        button.addEventListener("click", function() {
            window.location.href = "logout.php";
        });
    </script>

<style>
.profilebtn:hover::after {
    content: "<?php echo $valueOfEmail?>";
    position: absolute;
    color: black;
    background-color: white; 
    padding: 5px 5px;
    border-radius: 5px;
    font-size: 14px;
}
    </style>

            
            </div>

            <script>
                function loadHmPageContent(HmPage){
                    window.location.href = `HmNavbarpage.php?HmPage=${HmPage}`;
                }

                function goToHmCalendar(){
                    window.location.href = `HmCalendar.php`;
                }

                function goHmHome(){
            window.location.href = 'HmHomepage.php';
        }
                
    </script>


    
    </div>


    <div class="right">

    <div class="title">
    <h1 class="h1Title">Calendar</h1>
    <div class="lineSeparator">
    <p class="reminderText">Calendar monitoring uses digital calendars to track approved, pending, and declined events, aiding organization and preventing event for oversighting for both approvers and students.</p>
    </div>
    </div>

    <div class="container">
   <div class="upper">
   <div class="legend">
      <center><h2 style="font-size: 14px;">Legend</h2></center>
        <div class="legend-item">
          <div class="legend-marker" style="background-color: #FFDB58;"></div>
          <div style="color: black;">Pending Activites</div>
        </div>
        <div class="legend-item">
          <div class="legend-marker" style="background-color: #90EE90;"></div>
          <div style="color: black;">Approved Activities</div>
        </div>
        <div class="legend-item">
          <div class="legend-marker" style="background-color: #EE4B2B;"></div>
          <div style="color: black;">Rejected Activities</div>
        </div>
    </div>

   </div>
    
        <div id="calendar">
     
        </div><br><br><br>
    </div>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                    header:{
                    left:'prev,next',
                    center:'title',
                    right:'today'
                  },
                  events: 'events.php',
              eventRender: function(event, element) {
                element.find('.fc-title').append('<br/>' + "Start - " + event.start.format('hh:mm A') +
                    '<br/>' + "End - " + event.end.format('hh:mm A') +
                    '<br/>' + event.program_organization);
              element.find('.fc-time').remove();
              
              
              }

            });
        });
    </script>

    </div>
  </div>

 
</body>
</html>
<?php
} else{
    header("Location: Loginpage.php");
    exit();
}
?>
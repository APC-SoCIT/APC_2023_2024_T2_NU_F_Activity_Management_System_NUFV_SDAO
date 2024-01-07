<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/apprapproval.css">
    <title>Document</title>
</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
        <ul>
            <li><a href="ApprHomepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>
            <li><a href="ApprStatuspage.php" class="status"><img src="IMG/statusIcon.png" class="statusIcon">Activity Status</a></li>
            <li><a href="ApprApprovalpage.php" class="approvalworkflow"><img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</a></li>
            <li><a href="ApprTimelinepage.php" class="timeline"><img src="IMG/orgsIcon.png" class="timelineIcon">Completed Activities</a></li>
            <li><a href="ApprCalendarpage.php" class="calendar"><img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</a></li>
          
            
            <div class="line"></div>
        </ul>
        <div class=buttons>
        <button class="profilebtn"><img src="IMG/profile.png" alt=""></button>

        <!-- <a href="logout.php" class="logout">Logout</a> -->
        <button id="logoutbtn" class="lgoutbtn"><img src="IMG/exit.png"></button>
        <script>
        var button = document.getElementById("logoutbtn");
        button.addEventListener("click", function() {
            window.location.href = "logout.php";
        });
    </script>
     
    
        
        </div>
    </div>
        </div>
       

        <div class="right">
        <div class="title">
                <h1 class="h1Title">APPROVAL WORKFLOW</h1>
           
            <div class="lineSeparator"></div>

            </div>
            <div class="Content">
               

            </div>

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
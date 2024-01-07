<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/apprhome.css">
    <title>Document</title>
</head>
<body>
    <div class="split-background">

        <div class="top">
        <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
        </div>

            <div class="mid">
                <h1>HOME</h1> 
                <div class="line"></div>
            </div>

            <div class="bottom">
                <div class="cardHolder">
                <div class="card">
                <a href="ApprStatuspage.php" class="status"><img src="IMG/statusIcon2.png" class="statusIcon2">Activity Status</a>
                    <p class="p1">Provide real-time updates on ongoing events or activties.</p>
                </div>

                <div class="card">
                <a href="ApprApprovalpage.php" class="approval"><img src="IMG/approvalworkflowIcon2.png" class="Icon">Approval Workflow</a>
                    <p class="p2">Streamlines decision-making, enabling efficient review and approval of activities.</p>
                </div> 

                <div class="card">
                <a href="ApprTimelinepage.php" class="timeline"><img src="IMG/timeline2.png" class="Icon">Completed Activities</a>
                    <p class="p3">Provides a chronological overview of key events and milestones in the organization's history.</p>
                </div> 
                

                <div class="card">
                <a href="ApprCalendarpage.php" class="calendar"><img src="IMG/calendar2.png" class="calendarIcon">Activity Calendar</a>
                    <p class="p4">View and manage upcoming events and schedules.</p>
                </div>
        
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
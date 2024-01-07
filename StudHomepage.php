<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/studhome.css">
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
                <a href="index.html" class="sarf"><img src="IMG/approvalworkflowIcon2.png" class="Icon">SARF</a>
                    <p class="p1">Direct link to propose and gain approval for student-led activities, serving as a vital bridge between students and administration.</p>
                </div>

                <div class="card">
                <a href="StudStatuspage.php" class="approval"><img src="IMG/statusIcon2.png" class="statusIcon2">Activity Status</a>
                    <p class="p2">Streamlines decision-making, enabling efficient review and approval of activities.</p>
                </div> 

                <div class="card">
                <a href="StudReportspage.php" class="timeline"><img src="IMG/reportsIcon2.png" class="Icon">End Activity Report</a>
                    <p class="p3">Provides a chronological overview of key events and milestones in the organization's history.</p>
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
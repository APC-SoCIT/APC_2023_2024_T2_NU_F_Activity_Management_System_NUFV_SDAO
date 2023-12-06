<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Orgspage.css">
    <title>Document</title>
</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
        <ul>
            <li><a href="Homepage.php" class="home"><img src="homeIcon.png" class="homeIcon"></img>Home</a></li>
            <li><a href="Statuspage.php" class="status"><img src="statusIcon.png" class="statusIcon">Status</a></li>
            <li><a href="Orgspage.php" class="orgs"><img src="orgsIcon.png" class="orgsIcon">Orgs Timeline</a></li>
            <li><a href="Calendarpage.php" class="calendar"><img src="calendarIcon.png" class="calendarIcon">Calendar</a></li>
            <li><a href="Reportspage.php" class="reports"><img src="reportsIcon.png" class="reportsIcon">Reports</a></li>
            <div class="line"></div>
        </ul>
        <div class=buttons>
        <button class="profilebtn"><img src="profile.png" alt=""></button>

        <!-- <a href="logout.php" class="logout">Logout</a> -->
        <button id="logoutbtn" class="lgoutbtn"><img src="exit.png"></button>
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
                <h1>Organization</h1>
           
            <div class="lineOrgs">

            </div>

            </div>
            <div class="orgsContent">
                

            </div>

        </div>
    </div>
    
</body>
</html>

<?php
} else{
    header("Location: index.php");
    exit();
}
?>
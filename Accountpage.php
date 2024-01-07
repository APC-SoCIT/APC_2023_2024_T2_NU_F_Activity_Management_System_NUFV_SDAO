<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/account.css">

    <title>Document</title>
</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
        <ul>
            <li><a href="Homepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>
            <li><a href="Statuspage.php" class="status"><img src="IMG/statusIcon.png" class="statusIcon">Activity Status</a></li>
            <li><a href="Approvalpage.php" class="approvalworkflow"><img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</a></li>
            <li><a href="Timelinepage.php" class="timeline"><img src="IMG/orgsIcon.png" class="timelineIcon">Completed Activities</a></li>
            <li><a href="Calendarpage.php" class="calendar"><img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</a></li>
            <li><a href="Reportspage.php" class="reports"><img src="IMG/reportsIcon.png" class="reportsIcon">End Activity Report</a></li>
            <li><a href="Accountpage.php" class="accounts"><img src="IMG/accIcon.png" class="accountIcon">Manage Accounts</a></li>
            <div class="line"></div>
        </ul>
        <div class=buttons>
        <button class="profilebtn"><img src="IMG/profile.png" alt=""></button>

        <!-- <a href="logout.php" class="logout">Logout</a> -->
        <button id="logoutbtn1" class="lgoutbtn"><img src="IMG/exit.png"></button>
        <script>
        var button = document.getElementById("logoutbtn1");
        button.addEventListener("click", function() {
            window.location.href = "logout.php";
        });
    </script>
        
        </div>
    </div>
        </div>
       
        <div class="right">
        <div class="title">
                <h1 class="h1Title">ACCOUNT MANAGEMENT</h1>

            <div class="lineSeparator">
                <p class="reminderText">Update personal information, change passwords, set notification preferences, and manage security features, ensuring a tailored and secure experience.</p>
            </div>

            </div>
    


        <div id="page0" class="Content display">
            <?php include('pageZero.php'); ?>
        </div>

        <div id="page1" class="Content">
            <?php include('pageOne.php'); ?>
        </div>

        <div id="page2" class="Content">
            <?php include('pageTwo.php'); ?>
        </div>

        <div id="page3" class="Content">
            <?php include('pageThree.php'); ?>
        </div>

    <script>
    function showPage(pageId) {
        // Hide all tab content
        var page = document.getElementsByClassName('Content');
        for (var i = 0; i < page.length; i++) {
            page[i].classList.remove('display');
        }
    // Show the selected tab content
        document.getElementById(pageId).classList.add('display');
        
  }
</script>
 
<script>
    var page =document.getElementsByClassName('Content');
  function onBack() {
    if(page1.classList.contains('display')){
        showPage('page0');
    } else if(page2.classList.contains('display')){
        showPage('page0');
    } else if(page3.classList.contains('display')){
        showPage('page0');
    }
    
  }

  function onNext(){
    if(page1.classList.contains('display')){
        showPage('page2');
    } else if(page2.classList.contains('display')){
        showPage('page3');
    }
  }
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
<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/statusprogress.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Document</title>
</head>
<body>

      <div class="split-background">

        <div class="right">
        <div class="titleBox">
            <div class="upperTitle">
            <h1 class="h1Title">ACTIVITY STATUS</h1>
           
           <div class="lineSeparator"></div>

            </div>

            <div class="bottomTitle">
            <p class="reminderText">Activity Status offers a snapshot of ongoing events, showing their progress, completion, or any other pertinent status facilitating efficient management and coordination.</p>
    
            <div class="legendBox">
                <div class="legend">Legend</div>
                <div class="rejected">
                     <div class="redSquare"></div>Rejected Activities
                </div>
                <div class="pending">
                    <div class="yellowSquare"></div>Pending Activities
                </div>
                <div class="approved">
                    <div class="greenSquare"></div>Approved Activities
                </div>
            </div>
           
            </div>

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
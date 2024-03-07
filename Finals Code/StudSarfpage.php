<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
        $successMessage = "The form was successfully submitted.";
        unset($_SESSION['form_submitted']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/studsarf.css">
    <title>Document</title>

</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
        <ul>
            <li><a href="StudHomepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>

            <li><a href="StudSarfpage.php" class="form"><img src="IMG/form.png" class="formIcon">Request Form</a></li>

            <li><a href="StudStatuspage.php" class="status"><img src="IMG/statusIcon.png" class="statusIcon">Status</a></li>
            
            <li><a href="StudReportspage.php" class="reports"><img src="IMG/reportsIcon.png" class="reportsIcon">End Report</a></li>
           
          
            
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

        <?php
                        if (isset($successMessage)) {
                            echo 'var messageElement = document.querySelector(".formSubmitted");
                                if (!messageElement || messageElement.offsetHeight === 0) {
                                    setTimeout(function() {
                                        window.location.href = "StudHomepage.php";
                                    }, 3000);
                                }';
                        }
                        ?>
    </script>
     
    
        
        </div>
    </div>
        </div>
       

        <div class="right">
        <div class="title">
                <h1 class="h1Title"></h1>
           
            <div class="lineSeparator">

            </div>

            </div>
            <div class="Content">
                    <!-- CONTENT -------------------------------------------------------------------------------------- -->
                    <?php
                    if (isset($successMessage)) {
                        echo '<h1 class="ty">Thank You</h1>';
                        echo '<div class="lineSeparator2"></div>';
                        echo '<p class="formSubmitted">' . $successMessage . '</p>';
                    }
                    ?>
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
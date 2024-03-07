<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
    $department = 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/ManageHome.css">
    <title>Account Management</title>
    <script>
        function openMenu() {
            var menuPanel = document.getElementById("menuPanel");
            var userDisplay = document.getElementById("userDisplay");
            var whiteLine = document.getElementsByClassName("whiteLine");

            menuPanel.classList.toggle("show");
            userDisplay.classList.toggle("hide");

            for (var i = 0; i < whiteLine.length; i++) {
                whiteLine[i].classList.toggle("shorter");
                }      
            }

            function closeBtn(){
                var menuPanel = document.getElementById("menuPanel");
                var userDisplay = document.getElementById("userDisplay");
                var whiteLine = document.getElementsByClassName("whiteLine");

                menuPanel.classList.remove("show");
                setTimeout (function(){
                    userDisplay.classList.remove("hide");
                    for (var i = 0; i < whiteLine.length; i++) {
                    whiteLine[i].classList.remove("shorter");
                    }
                }, 200);
            }
    </script>
</head>
<body>
    <div class="split-background">

    <div class="top">
                <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">

                <div class="forUsers">
                    <div class="userDisplay" id="userDisplay"><?php echo $valueOfEmail ?></div>
                    <div class="menu" id="menu" onclick="openMenu()">
                        <div class="whiteLine"></div>
                        <div class="whiteLine"></div>
                        <div class="whiteLine"></div>
                        </div>

                        <div class="menuPanel" id="menuPanel">
                            <div class="userDetailHolder">
                                <div class="closeBtnContainer"><div class="closeBtn" onclick="closeBtn()" id="closeBtn">X</div></div>
                                <p class="userDetails">
                                    User :<br><span style="display:block; margin-top: 5px;"><?php echo $valueOfEmail ?></span> 
                                </p>
                                <p class="userDetails">Department :<br><span style="display:block; margin-top: 5px;"><?php echo $department?></span></p>
                            </div>
                       
                            <div class="menuPanelBtn">
                                <div class="btnHolder">
                                    <button id="logoutbtn"><img src="IMG/exit.png"></button>
                                </div>
                            </div>        
<script>
        var button = document.getElementById("logoutbtn");
        button.addEventListener("click", function() {
            window.location.href = "logout.php";
        });
    </script>                    
                        </div>
                    
                </div>
            </div>

            <div class="mid">
                <h1 class="h1Title">Account Management</h1> 
                <div class="line"></div>
            </div>

            <div class="bottom">
                <div class="cardHolder">

                   <a href="ManageAdmin.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">Admin Accounts</div>
            </a>

            <a href="ManageDirector.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">Director Accounts</div>
            </a>

            <a href="ManageFacility.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">Facility and Equipment Accounts</div>
            </a>

            <a href="ManageDean.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">College Dean Accounts</div>
            </a>

            <a href="ManagePchair.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">Program Chair Accounts</div>
            </a>

            <a href="ManageOAdviser.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">Organization Adviser Accounts</div>
            </a>

            <a href="ManageStudent.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">Student Accounts</div>
            </a>

            <a href="Homepage.php" class="card">
                <div class="a"><img src="IMG/profile2.png" class="Icon">Home</div>
            </a>
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
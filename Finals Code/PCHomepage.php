<?php
session_start();
include 'db_conn.php';
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
    
    $sqlOrg2 = "SELECT program_chair_program FROM nu_accountsdb.program_chair_approver WHERE program_chair_email = '$valueOfEmail'" ;
    $resultOrg2 = $conn->query($sqlOrg2);
    if (!$resultOrg2) {
        die("Query failed: " . $conn->error);
    }

    $org = "";
    if ($resultOrg2->num_rows > 0) {
        $rowOrg2 = $resultOrg2->fetch_assoc();
        $org = $rowOrg2['program_chair_program'];
        $sourceTable = "program_chair_approver";
    } else {
        die("Email not found in any table.");
    }
    $department = $org;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/orgadvhome.css">
    <title>Document</title>
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
                <h1 class="h1Title">HOME</h1> 
                <div class="line"></div>
            </div>

            <div class="bottom">
                <div class="cardHolder">
                    <div class="card" onclick="loadPCPageContent('PCStatus')">
                        <div class="a"><img src="IMG/statusIcon2.png" class="statusIcon2">Activity Status</div>
                        <p class="p1">Provide real-time updates on ongoing events or activties.</p>
                    </div>

                    <div class="card" onclick="loadPCPageContent('PCApproval')">
                        <div class="a"><img src="IMG/approvalworkflowIcon2.png" class="Icon">Approval Workflow</div>
                        <p class="p2">Streamlines decision-making, enabling efficient review and approval of activities.</p>
                    </div> 

                    <div class="card" onclick="goToPCCalendar()">
                        <div class="a"><img src="IMG/calendar2.png" class="calendarIcon">Activity Calendar</div>
                        <p class="p4">View and manage upcoming events and schedules.</p>
                    </div>

                </div>   
            </div>     

    </div>
    <script>
                function loadPCPageContent(PCPage){
                    window.location.href = `PCNavbarpage.php?PCPage=${PCPage}`;
                }

                function goToPCCalendar(){
                    window.location.href = `PCCalendar.php`;
                }
    </script>
    
</body>
</html>

<?php
} else{
    header("Location: Loginpage.php");
    exit();
}
?>
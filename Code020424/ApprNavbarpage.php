<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="CSS/apprnavbar.css" as="style">
    <link rel="stylesheet" href="CSS/apprnavbar.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="apprfunctions.js"></script>
    <title>Document</title>
</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
                 <!-- Your Sidebar/Buttons -->
            <button class="btnNavbar" onclick="goApprHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadApprPageContent('ApprStatuspage.php', 1)">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadApprPageContent('ApprApprovalpage.php', 2)">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>
            
            <button class="btnNavbar" onclick="loadApprPageContent('ApprTimelinepage.php', 3)">
            <img src="IMG/orgsIcon.png" class="timelineIcon">Completed Activities</button>
       
            <button class="btnNavbar" onclick="loadApprPageContent('ApprCalendarpage.php', 4)">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            

            
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadApprPageContent(ApprPage) {
            $.ajax({
                url: ApprPage,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                

                    history.pushState(null, null, `ApprNavbarpage.php?ApprPage=${ApprPage}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }
    </script>

<script>
        // Function to retrieve the activeButton value from the query parameter
        function getApprActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('ApprPage'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let ApprPage = getApprActivePageFromQuery();

            if (ApprPage === 'ApprStatus') {
                loadApprPageContent('ApprStatuspage.php');  
            } else if (ApprPage === 'ApprApproval') {
                loadApprPageContent('ApprApprovalpage.php');
            } else if (ApprPage === 'ApprTimeline') {
                loadApprPageContent('ApprTimelinepage.php');
            }
            else if (ApprPage === 'ApprCalendar') {
                loadApprPageContent('ApprCalendarpage.php');
            }
            else if (ApprPage === 'ApprReports') {
                loadApprPageContent('ApprReportspage.php');
            }
            else{
                window.location.href = 'ApprHomepage.php';
                return;
            }
        });
    </script>
      
        <script>
        function displayAccount(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.container').html(data);  
                    
                },
            });
           
        }
    </script>
<!---HOME BUTTON----------------------------------------------------------------------------------->
    <script>
        function goApprHome(){
            window.location.href = 'ApprHomepage.php';
        }
    </script>

<!--------------------------------------------------------------------------------------------------->

        <div class="line"></div>
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

<script>
         function approveRequestFmo(org) {
            $.ajax({
                type: 'POST',
                url: 'update_status_FMO.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var pPendingDetail = document.getElementById('pendingDetailFMO');
                    pPendingDetail.textContent = 'APPROVED';
                    pPendingDetail.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove.style.backgroundColor = 'rgba(151, 239, 120, 1)';
                    imagePendingToApprove.src = 'IMG/check.png';
                    imagePendingToApprove.style.padding = '1px';
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        }
</script>




            
        </div>
    </div>
        </div>
       
        <div class="right">
        <div class="title">
                <h1 class="h1Title">ACTIVITY STATUS</h1>
           
            <div class="lineSeparator">

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
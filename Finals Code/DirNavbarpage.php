<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="CSS/dirnavbar.css" as="style">
    <link rel="stylesheet" href="CSS/dirnavbar.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="dirfunctions.js"></script>
    <title>Document</title>
</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
               
            <button class="btnNavbar" onclick="goDirHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadDirPageContent('DirStatuspage.php')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadDirPageContent('DirApprovalpage.php')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>
            
            <button class="btnNavbar" onclick="loadDirPageContent('DirTimeline.php')">
            <img src="IMG/orgsIcon.png" class="timelineIcon">Completed Activities</button>
       
            <button class="btnNavbar" onclick="goToDirCalendar()">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            
            <button class="btnNavbar" onclick="loadDirPageContent('ReportsDirector.php')">
            <img src="IMG/reportsIcon.png" class="reportsIcon">End Activity Report</button>
            
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadDirPageContent(DirPage) {
            $.ajax({
                url: DirPage,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                    history.pushState(null, null, `DirNavbarpage.php?DirPage=${DirPage}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }
    </script>

<script>
        // Function to retrieve the activeButton value from the query parameter
        function getDirActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('DirPage'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let DirPage = getDirActivePageFromQuery();

            if (DirPage === 'DirStatus') {
                loadDirPageContent('DirStatuspage.php');  
            } else if (DirPage === 'DirApproval') {
                loadDirPageContent('DirApprovalpage.php');
            } else if (DirPage === 'DirTimeline') {
                loadDirPageContent('DirTimeline.php');
            }
            else if (DirPage === 'DirCalendar') {
                window.location.href = `DirCalendar.php`;
            }
            else if (DirPage === 'DirReports') {
                loadDirPageContent('ReportsDirector.php');
            }
            else{
                window.location.href = 'DirHomepage.php';
                return;
            }
        });
        function goDirHome(){
            window.location.href = 'DirHomepage.php';
        }

                function goToDirCalendar(){
                    window.location.href = `DirCalendar.php`;
                }
   
    </script>


<!------------------------------------------------------------------------------------>


<!--------------------------------------------------------------------------------------------------->

<div class="outterline">
            <div class="line"></div>
            <div class="buttons">
        <button class="profilebtn"><img src="IMG/profile.png" alt=""></button>

        <button id="logoutbtn" class="lgoutbtn"><img src="IMG/exit.png"></button>
        </div>


            </div>

        <script>
        var button = document.getElementById("logoutbtn");
        button.addEventListener("click", function() {
            window.location.href = "logout.php";
        });
    </script>

<style>
.profilebtn:hover::after {
    content: "<?php echo $valueOfEmail?>";
    position: absolute;
    color: black;
    background-color: white; 
    padding: 5px 5px;
    border-radius: 5px;
    font-size: 14px;
}
    </style>


<script>
    var doneClicking = false;
         function approveRequestASD(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;
            $.ajax({
                type: 'POST',
                url: 'update_status_ASD.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove5 = document.getElementById('pendingToApproveImg5');
                    var pPendingDetail5 = document.getElementById('pendingDetailASD');
                    var idrejectBtn = document.getElementById('rejectBtnId');
                    var approveBtn = document.getElementById('approveBtn');
                    var rejectBtn = document.querySelector('.rejectBtn');
                    var qapproveBtn = document.querySelector('.approveBtn');
                    var btnContainer = document.querySelector('.rejectApproveBtnContainer');
                    
                    qapproveBtn.style.cursor = 'default';
                    qapproveBtn.style.width = '200px';
                    qapproveBtn.textContent = 'Done';
                    rejectBtn.style.display = 'none'; 
                    btnContainer.style.justifyContent = 'center';

                    pPendingDetail5.textContent = 'APPROVED';
                    pPendingDetail5.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove5.style.color = 'green';
                    imagePendingToApprove5.src = 'IMG/approvedIcon.png';
                    idrejectBtn.style.visibility = 'hidden';
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        }
</script>

<script>
    var doneClicking = false;
         function approveRequestSAD(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;
            $.ajax({
                type: 'POST',
                url: 'update_status_SAD.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove6 = document.getElementById('pendingToApproveImg6');
                    var pPendingDetail6 = document.getElementById('pendingDetailSAD');
                    var idrejectBtn = document.getElementById('rejectBtnId');
                    var approveBtn = document.getElementById('approveBtn');
                    var rejectBtn = document.querySelector('.rejectBtn');
                    var qapproveBtn = document.querySelector('.approveBtn');
                    var btnContainer = document.querySelector('.rejectApproveBtnContainer');
                    
                    qapproveBtn.style.cursor = 'default';
                    qapproveBtn.style.width = '200px';
                    qapproveBtn.textContent = 'Done';
                    rejectBtn.style.display = 'none'; 
                    btnContainer.style.justifyContent = 'center';

                    pPendingDetail6.textContent = 'APPROVED';
                    pPendingDetail6.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove6.style.color = 'green';
                    imagePendingToApprove6.src = 'IMG/approvedIcon.png';
                    idrejectBtn.style.visibility = 'hidden';
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        }
</script>

<script>
    var doneClicking = false;
         function approveRequestED(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;
            $.ajax({
                type: 'POST',
                url: 'update_status_ED.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove7 = document.getElementById('pendingToApproveImg7');
                    var pPendingDetail7 = document.getElementById('pendingDetailED');
                    var idrejectBtn = document.getElementById('rejectBtnId');
                    var approveBtn = document.getElementById('approveBtn');
                    var rejectBtn = document.querySelector('.rejectBtn');
                    var qapproveBtn = document.querySelector('.approveBtn');
                    var btnContainer = document.querySelector('.rejectApproveBtnContainer');
                    
                    qapproveBtn.style.cursor = 'default';
                    qapproveBtn.style.width = '200px';
                    qapproveBtn.textContent = 'Done';
                    rejectBtn.style.display = 'none'; 
                    btnContainer.style.justifyContent = 'center';

                    pPendingDetail7.textContent = 'APPROVED';
                    pPendingDetail7.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove7.style.color = 'green';
                    imagePendingToApprove7.src = 'IMG/approvedIcon.png';
                    idrejectBtn.style.visibility = 'hidden';
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        }
</script>

<script>
    function goToDirStatus(programOrganization) {
        var page = 'DirStatusProgresspage.php?org=' + programOrganization;
        $.ajax({
            url: page,
            type: 'GET',
            success: function(data) {
                $('.right').html(data);  
            },
        });
    }
   </script>  

<script>
  function showRejectRequestFmo() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('rejectCommentBox').style.display = 'block';     
  }
  function hideRejectRequestFmo() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('rejectCommentBox').style.display = 'none';
  }
  function proceedRejectFunction(org) {
    var trimmedComment = document.getElementById('commentInput').value.trim();

    if (trimmedComment !== '') {
        $.ajax({
            type: 'POST',
            url:'reject_status.php',
            data: { org: org },
            success: function (rejectStatus){
                hideRejectRequestFmo();
                doneRejecting();             
            },
        });  
    } else {
    }
}

function doneRejecting() {
            $.ajax({
                url: 'DirApprovalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                        
                },
            });
           
        }
</script>




            
        
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
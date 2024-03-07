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
    <link rel="preload" href="CSS/Navbar.css" as="style">
    <link rel="stylesheet" href="CSS/Navbar.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>

    <title>Document</title>
</head>
<body>
    
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
            
            <button class="btnNavbar" onclick="goHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadContent('Statuspage.php')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadContent('Approvalpage.php')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>
            
            <button class="btnNavbar" onclick="loadContent('Timeline.php')">
            <img src="IMG/orgsIcon.png" class="timelineIcon">Completed Activities</button>
       
            <button class="btnNavbar" onclick="goToCalendar()">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            
            <button class="btnNavbar" onclick="loadContent('Reports.php')">
            <img src="IMG/reportsIcon.png" class="reportsIcon">End Activity Report</button>
            
            <button id="accBtnNavbar" class="btnNavbar" onclick="loadAccountpage()">
            <img src="IMG/accIcon.png" class="accountsIcon">Manage Accounts</button>
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadContent(Page) {
            $.ajax({
                url: Page,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                    history.pushState(null, null, `Navbarpage.php?Page=${Page}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          //$('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }

        function loadAccountpage(){
            window.location.href = 'ManageAdmin.php';
        }
    </script>

<script>
        function getActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('Page'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let Page = getActivePageFromQuery();

            if (Page === 'Status') {
                loadContent('Statuspage.php');  
            } else if (Page === 'Approval') {
                loadContent('Approvalpage.php');
            } else if (Page === 'Timeline') {
                loadContent('Timeline.php');
            }
            else if (Page === 'Calendar') {
                window.location.href = `Calendar.php`;            
            }
            else if (Page === 'Reports') {
                loadContent('Reports.php');
            }
            else if (Page === 'Accounts') {
                window.location.href = 'ManageAdmin.php';
            }
            else{
                window.location.href = 'Homepage.php';
                return;
            }
        });
        function goHome(){
            window.location.href = 'Homepage.php';
        }


        function goToCalendar(){
                    window.location.href = `Calendar.php`;
                }
    </script>
      
  

<!--DISPLAY ACCOUNTS ON MANAGE ACCOUNTS FUNCTION-------------------------------------->    
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
    function approveSDAOandEmailFMO(org){
        approveRequestSdao(org);
        sendMailToFMO(org);
    }
    function approveSDAOandEmailITSO(org){
        approveRequestSdao(org);
        sendMailToITSO(org);
    }
    function approveSDAOandEmailLRC(org){
        approveRequestSdao(org);
        sendMailToLRC(org);
    }
    function approveSDAOandEmailHM(org){
        approveRequestSdao(org);
        sendMailToHM(org);
    }

  
          function approveRequestSdao(org) {
            $.ajax({
                type: 'POST',
                url: 'update_status_SDAO.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var pPendingDetail = document.getElementById('pendingDetailSDAO');
                    var idrejectBtn = document.getElementById('rejectBtnId');
                    var approveBtn = document.getElementById('approveBtn');
                    var rejectBtn = document.querySelector('.rejectBtn');
                    var qapproveBtn = document.querySelector('.approveBtn');
                    var btnContainer = document.querySelector('.rejectApproveBtnContainer');
                    
                    qapproveBtn.style.cursor = 'default';
                    qapproveBtn.style.width = '200px';
                    qapproveBtn.textContent = 'DONE';
                    qapproveBtn.onclick = null;
                    rejectBtn.style.display = 'none'; 
                    btnContainer.style.justifyContent = 'center';

                    pPendingDetail.textContent = 'APPROVED';
                    pPendingDetail.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove.style.color = 'green';
                    imagePendingToApprove.src = 'IMG/approvedIcon.png';
                    imagePendingToApprove.style.padding = '0px';
                    idrejectBtn.style.visibility = 'hidden';
                    
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        }

        function sendMailToFMO(org){
            var message = "The " + org + "'s request has been approved by the SDAO. You may now approve or reject the request.";
            $.ajax({
                    type: 'POST',
                    url: 'send.php', 
                    data: { 
                        email: 'facilitiesmanoffice@gmail.com', 
                        subject: 'For FMO Approver',
                        message: message
                    },
                    success: function (response) {
                        console.log('Email sent successfully');
                    },
                    error: function (error) {
                        console.error('Error sending email:', error);
                        // Handle the error if needed
                    }
                });
        }

        function sendMailToITSO(org){
            var message = "The " + org + "'s request has been approved by the SDAO. You may now approve or reject the request.";
            $.ajax({
                    type: 'POST',
                    url: 'send.php', 
                    data: { 
                        email: 'itsoapp111@gmail.com', 
                        subject: 'For ITSO Approver',
                        message: message
                    },
                    success: function (response) {
                        console.log('Email sent successfully');
                    },
                    error: function (error) {
                        console.error('Error sending email:', error);
                        // Handle the error if needed
                    }
                });
        }

        
        function sendMailToLRC(org){
            var message = "The " + org + "'s request has been approved by the SDAO. You may now approve or reject the request.";
            $.ajax({
                    type: 'POST',
                    url: 'send.php', 
                    data: { 
                        email: 'learningrcnu@gmail.com', 
                        subject: 'For LRC Approver',
                        message: message
                    },
                    success: function (response) {
                        console.log('Email sent successfully');
                    },
                    error: function (error) {
                        console.error('Error sending email:', error);
                        // Handle the error if needed
                    }
                });
        }

        function sendMailToHM(org){
            var message = "The " + org + "'s request has been approved by the SDAO. You may now approve or reject the request.";
           
            $.ajax({
                    type: 'POST',
                    url: 'send.php', 
                    data: { 
                        email: 'hotelmapp666@gmail.com', 
                        subject: 'For HM Approver',
                        message: message
                    },
                    success: function (response) {
                        console.log('Email sent successfully');
                    },
                    error: function (error) {
                        console.error('Error sending email:', error);
                        // Handle the error if needed
                    }
                });
        }

        function nothing(){

        }

</script>





<script>
  function showRejectRequestSdao() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('rejectCommentBox').style.display = 'block';     
  }
  function hideRejectRequestSdao() {
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
                hideRejectRequestSdao();
                doneRejecting();             
            },
        });  
    } else {
    }
}

function doneRejecting() {
            $.ajax({
                url: 'Approvalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                        
                },
            });
           
        }
</script>

<script>
    function goToHomepage(){
        $.ajax({
                url: 'Approvalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                },
            });
        }
</script>



<script>
    function goToStatus(programOrganization) {
        var page = 'StatusProgresspage.php?org=' + programOrganization;
        $.ajax({
            url: page,
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
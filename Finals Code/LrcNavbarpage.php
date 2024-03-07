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
            <button class="btnNavbar" onclick="goLrcHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadLrcPageContent('LrcStatuspage.php')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadLrcPageContent('LrcApprovalpage.php')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>

            <button class="btnNavbar" onclick="goToLrcCalendar()">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            

            
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadLrcPageContent(LrcPage) {
            $.ajax({
                url: LrcPage,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                

                    history.pushState(null, null, `LrcNavbarpage.php?LrcPage=${LrcPage}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }
    </script>

<script>
        // Function to retrieve the activeButton value from the query parameter
        function getLrcActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('LrcPage'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let LrcPage = getLrcActivePageFromQuery();

            if (LrcPage === 'LrcStatus') {
                loadLrcPageContent('LrcStatuspage.php');  
            } else if (LrcPage === 'LrcApproval') {
                loadLrcPageContent('LrcApprovalpage.php');
            } else if (LrcPage === 'LrcCalendar') {
                window.location.href = `LrcCalendar.php`;
            }
            else if (LrcPage === 'LrcReports') {
                loadLrcPageContent('LrcReportspage.php');
            }
            else{
                window.location.href = 'LrcHomepage.php';
                return;
            }
        });

        function goLrcHome(){
            window.location.href = 'LrcHomepage.php';
        }

        function goToLrcCalendar(){
                    window.location.href = `LrcCalendar.php`;
                }



    </script>
      

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
        function approveLrcOnly(org){
        approveRequestLRC(org);
    }

    function approveAndMailAsd(org){
        approveRequestLRC(org);
        sendMailToASD(org)

    }



    var doneClicking = false;
         function approveRequestLRC(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;
            $.ajax({
                type: 'POST',
                url: 'update_status_LRC.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var pPendingDetail2 = document.getElementById('pendingDetailLRC');
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

                    pPendingDetail2.textContent = 'APPROVED';
                    pPendingDetail2.style.backgroundColor = 'rgba(153, 217, 71, 1)';
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

        function sendMailToASD(org){
            var message = "The " + org + "'s request has been approved by the Facilities Approvers. You may now approve or reject the request.";
            $.ajax({
                    type: 'POST',
                    url: 'send.php', 
                    data: { 
                        email: 'academicservdir@gmail.com', 
                        subject: 'For Academic Service Director',
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
</script>

<script>
  function showRejectRequestLrc() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('rejectCommentBox').style.display = 'block';     
  }
  function hideRejectRequestLrc() {
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
                hideRejectRequestLrc();
                doneRejecting();             
            },
        });  
    } else {
    }
}

function doneRejecting() {
            $.ajax({
                url: 'LrcApprovalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                        
                },
            });
           
        }
</script>

<script>
    function goToLrcStatus(programOrg) {
        var page = 'LrcStatusProgresspage.php?org=' + programOrg;
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
    function goToLrcApproval(programOrg) {
        var page = 'LrcApprovalProgresspage.php?org=' + programOrg;
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
    
</body>
</html>

<?php
} else{
    header("Location: Loginpage.php");
    exit();
}
?>
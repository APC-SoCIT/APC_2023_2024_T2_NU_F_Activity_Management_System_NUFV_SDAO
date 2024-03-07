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
            <button class="btnNavbar" onclick="goItsoHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadItsoPageContent('ItsoStatuspage.php')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadItsoPageContent('ItsoApprovalpage.php')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>

            <button class="btnNavbar" onclick="goToItsoCalendar()">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            

            
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadItsoPageContent(ItsoPage) {
            $.ajax({
                url: ItsoPage,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                

                    history.pushState(null, null, `ItsoNavbarpage.php?ItsoPage=${ItsoPage}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }
    </script>

<script>
        // Function to retrieve the activeButton value from the query parameter
        function getItsoActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('ItsoPage'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let ItsoPage = getItsoActivePageFromQuery();

            if (ItsoPage === 'ItsoStatus') {
                loadItsoPageContent('ItsoStatuspage.php');  
            } else if (ItsoPage === 'ItsoApproval') {
                loadItsoPageContent('ItsoApprovalpage.php');
            } else if (ItsoPage === 'ItsoCalendar') {
                window.location.href = `ItsoCalendar.php`;
            }
            else if (ItsoPage === 'ItsoReports') {
                loadItsoPageContent('ItsoReportspage.php');
            }
            else{
                window.location.href = 'ItsoHomepage.php';
                return;
            }
        });

        function goItsoHome(){
            window.location.href = 'ItsoHomepage.php';
        }

        function goToItsoCalendar(){
                    window.location.href = `ItsoCalendar.php`;
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
       function approveItsoOnly(org){
        approveRequestITSO(org);
    }

    function approveAndMailAsd(org){
        approveRequestITSO(org);
        sendMailToASD(org)

    }



    var doneClicking = false;
         function approveRequestITSO(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;
            $.ajax({
                type: 'POST',
                url: 'update_status_ITSO.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove2 = document.getElementById('pendingToApproveImg2');
                    var pPendingDetail2 = document.getElementById('pendingDetailITSO');
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
                    imagePendingToApprove2.style.color = 'green';
                    imagePendingToApprove2.src = 'IMG/approvedIcon.png';
                    imagePendingToApprove2.style.padding = '0px';
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
  function showRejectRequestItso() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('rejectCommentBox').style.display = 'block';     
  }
  function hideRejectRequestItso() {
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
                hideRejectRequestItso();
                doneRejecting();             
            },
        });  
    } else {
    }
}

function doneRejecting() {
            $.ajax({
                url: 'ItsoApprovalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                        
                },
            });
           
        }
</script>

<script>
    function goToItsoStatus(programOrg) {
        var page = 'ItsoStatusProgresspage.php?org=' + programOrg;
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
    function goToItsoApproval(programOrg) {
        var page = 'ItsoApprovalProgresspage.php?org=' + programOrg;
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
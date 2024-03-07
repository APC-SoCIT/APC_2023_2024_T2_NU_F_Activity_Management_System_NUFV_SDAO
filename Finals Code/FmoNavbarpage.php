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
            <button class="btnNavbar" onclick="goFmoHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadFmoPageContent('FmoStatuspage.php')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadFmoPageContent('FmoApprovalpage.php')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>

            <button class="btnNavbar" onclick="goToFmoCalendar()">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            

            
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadFmoPageContent(FmoPage) {
            $.ajax({
                url: FmoPage,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                

                    history.pushState(null, null, `FmoNavbarpage.php?FmoPage=${FmoPage}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }
    </script>

<script>
        // Function to retrieve the activeButton value from the query parameter
        function getFmoActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('FmoPage'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let FmoPage = getFmoActivePageFromQuery();

            if (FmoPage === 'FmoStatus') {
                loadFmoPageContent('FmoStatuspage.php');  
            } else if (FmoPage === 'FmoApproval') {
                loadFmoPageContent('FmoApprovalpage.php');
            } else if (FmoPage === 'FmoCalendar') {
                window.location.href = `FmoCalendar.php`;
            }
            else if (FmoPage === 'FmoReports') {
                loadFmoPageContent('FmoReportspage.php');
            }
            else{
                window.location.href = 'FmoHomepage.php';
                return;
            }
        });

        function goFmoHome(){
            window.location.href = 'FmoHomepage.php';
        }

        function goToFmoCalendar(){
                    window.location.href = `FmoCalendar.php`;
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
    function approveFmoOnly(org){
        approveRequestFmo(org);
    }

    function approveAndMailAsd(org){
        approveRequestFmo(org);
        sendMailToASD(org)

    }





    var doneClicking = false;
         function approveRequestFmo(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;
            $.ajax({
                type: 'POST',
                url: 'update_status_FMO.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var pPendingDetail = document.getElementById('pendingDetailFMO');
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
                url: 'FmoApprovalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                        
                },
            });
           
        }
</script>

<script>
    function goToFmoStatus(programOrg) {
        var page = 'FmoStatusProgresspage.php?org=' + programOrg;
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
    function goToFmoApproval(programOrg) {
        var page = 'FmoApprovalProgresspage.php?org=' + programOrg;
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
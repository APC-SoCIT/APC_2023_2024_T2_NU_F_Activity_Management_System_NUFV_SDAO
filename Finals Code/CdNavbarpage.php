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
    <link rel="preload" href="CSS/orgadvnavbar.css" as="style">
    <link rel="stylesheet" href="CSS/cdnavbar.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <title>Document</title>
</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
                 <!-- Your Sidebar/Buttons -->
            <button class="btnNavbar" onclick="CdHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadCdPageContent('CdStatuspage.php')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadCdPageContent('CdApprovalpage.php')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>
       
            <button class="btnNavbar" onclick="goToCdCalendar()">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            

            
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadCdPageContent(CdPage) {
            $.ajax({
                url: CdPage,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                

                    history.pushState(null, null, `CdNavbarpage.php?CdPage=${CdPage}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }
    </script>

<script>
        // Function to retrieve the activeButton value from the query parameter
        function getCdActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('CdPage'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let CdPage = getCdActivePageFromQuery();

            if (CdPage === 'CdStatus') {
                loadCdPageContent('CdStatuspage.php');  
            } else if (CdPage === 'CdApproval') {
                loadCdPageContent('CdApprovalpage.php');
            } else if (CdPage === 'CdTimeline') {
                loadCdPageContent('CdTimelinepage.php');
            }
            else if (CdPage === 'CdCalendar') {
                loadCdPageContent('CdCalendarpage.php');
            }
            else{
                window.location.href = 'CdHomepage.php';
                return;
            }
        });

        function CdHome(){
            window.location.href = 'CdHomepage.php';
        }

        function goToCdCalendar(){
                    window.location.href = `CdCalendar.php`;
                }

    </script>
      


<!--------------------------------------------------------------------------------------------------->
<script>
    function goToCdApproval(programOrg) {
        var page = 'CdApprovalProgresspage.php?org=' + programOrg;
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
    function goToCdStatusProgress(programOrg) {
        var page = 'CdStatusProgresspage.php?org=' + programOrg;
        $.ajax({
            url: page,
            type: 'GET',
            success: function(data) {
                $('.right').html(data);  
            },
        });
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
         function approveRequestCD(org) {
            $.ajax({
                type: 'POST',
                url: 'update_status_CD.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var pPendingDetail = document.getElementById('pendingDetail');
                    var idrejectBtn = document.getElementById('rejectBtnId');
                    var approveBtn =document.getElementById('approveBtn');
                    var btnContainer = document.querySelector('.rejectApproveBtnContainer');

                    pPendingDetail.textContent = 'APPROVED';
                    pPendingDetail.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove.src = 'IMG/approvedIcon.png';
                    imagePendingToApprove.style.color = 'green';
                    imagePendingToApprove.style.width = '33px';
                    imagePendingToApprove.style.padding = '0px';
                    
                    idrejectBtn.style.display = 'none';
                    
                    approveBtn.style.cursor = 'default';
                    approveBtn.style.width = '200px';
                    approveBtn.textContent = 'Done'; 
                    btnContainer.style.justifyContent = 'center';

                     var recipient = '';

                    if(org === 'Codability Tech Student Organization'){
                        recipient = 'itprogchair@gmail.com';
                    }else{
                        recipient = 'emailfornotif@gmail.com'
                    }

                    var message = "The " + org + "'s request has been approved by their college dean. You may now approve or reject the request.";

                    $.ajax({
                    type: 'POST',
                    url: 'send.php', 
                    data: { 
                        email: recipient, 
                        subject: 'For Program Chair Approver',
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

                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }
</script>





<script>
  function showRejectRequestCD() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('rejectCommentBox').style.display = 'block';
  }
  function hideRejectRequestCD() {
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
                hideRejectRequestCD();
                doneRejecting();
            },
        });  
    } else {
    }
}

function doneRejecting() {
            $.ajax({
                url: 'OrgAdvApprovalpage.php',
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
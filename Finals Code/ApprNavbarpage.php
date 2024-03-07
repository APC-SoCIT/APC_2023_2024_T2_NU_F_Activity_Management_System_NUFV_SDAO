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
            <button class="btnNavbar" onclick="goApprHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadApprPageContent('ApprStatuspage.php')">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadApprPageContent('ApprApprovalpage.php')">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>

            <button class="btnNavbar" onclick="goToApprCalendar()">
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
            } else if (ApprPage === 'ApprCalendar') {
                window.location.href = `ApprCalendar.php`;
            }
            else if (ApprPage === 'ApprReports') {
                loadApprPageContent('ApprReportspage.php');
            }
            else{
                window.location.href = 'ApprHomepage.php';
                return;
            }
        });

        function goApprHome(){
            window.location.href = 'ApprHomepage.php';
        }

        function goToApprCalendar(){
                    window.location.href = `ApprCalendar.php`;
                }



    </script>
      
        <script>
        function goToApprApproval(programOrg) {
    var page = 'ApprApprovalProgresspage.php?org=' + programOrg;
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
                    var imagePendingToApprove3 = document.getElementById('pendingToApproveImg3');
                    var pPendingDetail3 = document.getElementById('pendingDetailLRC');
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

                    pPendingDetail3.textContent = 'APPROVED';
                    pPendingDetail3.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove3.style.color = 'green';
                    imagePendingToApprove3.src = 'IMG/approvedIcon.png';
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
         function approveRequestHM(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;
            $.ajax({
                type: 'POST',
                url: 'update_status_HM.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove4 = document.getElementById('pendingToApproveImg4');
                    var pPendingDetail4 = document.getElementById('pendingDetailHM');
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

                    pPendingDetail4.textContent = 'APPROVED';
                    pPendingDetail4.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove4.style.color = 'green';
                    imagePendingToApprove4.src = 'IMG/approvedIcon.png';
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
                url: 'ApprApprovalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                        
                },
            });
           
        }
</script>

<script>
    function goToApprStatus(programOrg) {
        var page = 'ApprStatusProgresspage.php?org=' + programOrg;
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
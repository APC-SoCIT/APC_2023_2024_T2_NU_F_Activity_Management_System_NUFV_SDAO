<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                 <!-- Your Sidebar/Buttons -->
            <button class="btnNavbar" onclick="goHome()">
            <img src="IMG/homeIcon2.png" class="homeIcon">Home</button>
            

            <button class="btnNavbar" onclick="loadContent('Statuspage.php', 1)">
            <img src="IMG/statusIcon.png" class="statusIcon">Activity Status</button>


            <button class="btnNavbar" onclick="loadContent('Approvalpage.php', 2)">
            <img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</button>
            
            <button class="btnNavbar" onclick="loadContent('Timelinepage.php', 3)">
            <img src="IMG/orgsIcon.png" class="timelineIcon">Completed Activities</button>
       
            <button class="btnNavbar" onclick="loadContent('Calendarpage.php', 4)">
            <img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</button>
            
            <button class="btnNavbar" onclick="loadContent('Reportspage.php', 5)">
            <img src="IMG/reportsIcon.png" class="reportsIcon">End Activity Report</button>
            
            <button id="accBtnNavbar" class="btnNavbar" onclick="loadContent('Accountpage.php', 6)">
            <img src="IMG/accIcon.png" class="accountsIcon">Manage Accounts</button>
           
<!---------------------------------------------------------------------------------------------------------------------------->
      
            <script>
        function loadContent(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                

                    history.pushState(null, null, `Navbarpage.php?Page=${page}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }
    </script>

<script>
        // Function to retrieve the activeButton value from the query parameter
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
                loadContent('Timelinepage.php');
            }
            else if (Page === 'Calendar') {
                loadContent('Calendarpage.php');
            }
            else if (Page === 'Reports') {
                loadContent('Reportspage.php');
            }
            else if (Page === 'Accounts') {
                loadContent('Accountpage.php');
            }
            else{
                window.location.href = 'Homepage.php';
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

<!--onBack and onNext function-------------------------------------------------------->
<script>
  var page =document.getElementsByClassName('Content');
  function onBack() {
    if(page1.classList.contains('display')){
        showPage('page0');
    } else if(page2.classList.contains('display')){
        showPage('page0');
    } else if(page3.classList.contains('display')){
        showPage('page0');
    }
  }
  function onNext(){
    if(page1.classList.contains('display')){
        showPage('page2');
    } else if(page2.classList.contains('display')){
        showPage('page3');
    }
  }
</script>
<!------------------------------------------------------------------------------------>


<!---HOME BUTTON----------------------------------------------------------------------------------->
    <script>
        function goHome(){
            window.location.href = 'Homepage.php';
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
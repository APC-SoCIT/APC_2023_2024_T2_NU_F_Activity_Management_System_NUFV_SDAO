<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/apprcalendar.css">
    <title>Document</title>
</head>
<body>
      <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
        <ul>
            <li><a href="ApprHomepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>
            <li><a href="ApprStatuspage.php" class="status"><img src="IMG/statusIcon.png" class="statusIcon">Activity Status</a></li>
            <li><a href="ApprApprovalpage.php" class="approvalworkflow"><img src="IMG/approvalworkflowIcon.png" class="approvalworkflowIcon">Approval Workflow</a></li>
            <li><a href="ApprTimelinepage.php" class="timeline"><img src="IMG/orgsIcon.png" class="timelineIcon">Completed Activities</a></li>
            <li><a href="ApprCalendarpage.php" class="calendar"><img src="IMG/calendarIcon.png" class="calendarIcon">Activity Calendar</a></li>
          
            
            <div class="line"></div>
        </ul>
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
                <h1 class="h1Title">CALENDAR</h1>
           
            <div class="lineSeparator">

            </div>

            </div>
            <div class="Content">
            <h1 class="date">January 2024</h1>
                <style>
                    date{
                        text-align: center; 
                    }
                </style>
                <br>
            <table border="1">

<tr>
</tr>

<tr>
<th>Sunday</th>
<th>Monday</th>
<th>Tuesday</th>
<th>Wednesday</th>
<th>Thursday</th>
<th>Friday</th>
<th>Saturday</th>
</tr>

<tr>
<td>1</td>
<td>2</td>
<td>3</td>
<td>4</td>
<td>5</td>
<td>6</td>
<td>7</td>
</tr>

<tr>
<td>8</td>
<td>9</td>
<td>10</td>
<td>11</td>
<td>12</td>
<td>13</td>
<td>14</td>
</tr>

<tr>
<td>15</td>
<td>16</td>
<td>17</td>
<td>18</td>
<td>19</td>
<td>20</td>
<td>21</td>
</tr>

<tr>
<td>22</td>
<td>23</td>
<td>24</td>
<td>25</td>
<td>26</td>
<td>27</td>
<td>28</td>
</tr>

<tr>
<td>29</td>
<td>30</td>
<td>31</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

</table>
<style>
    table{
        table-layout: fixed;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }
    table, td{
        width: 920px;
        height: 90px;
        border-collapse: collapse;
        text-align: left;
        vertical-align: top;
        color: rgba(53,64,142,1);
    }

    th{
        height: 20px;
        border-collapse: collapse;
        text-align: center;
    }


</style>
     
               

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
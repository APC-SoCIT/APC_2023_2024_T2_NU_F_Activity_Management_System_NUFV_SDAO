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
    <link rel="stylesheet" href="CSS/cdstatus.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Document</title>
</head>
<body>
        <div class="right">
        <div class="title">
                <h1 class="h1Title">ACTIVITY STATUS</h1>     
            <div class="lineSeparator">
            <p class="reminderText">Activity Status offers a snapshot of ongoing events, showing their progress, completion, or any other pertinent status facilitating efficient management and coordination. To access the main page of the activity status, click the text under the orgs name column (Example: Codability)</p>

            </div>

            </div>
            <div class="Content">
                <div class="innerPageContent">

                
            <?php
       $sname = "localhost:3307";
       $uname = "root";
       $password = "";
       $db_name = "sarf";

       $conn = new mysqli($sname, $uname, $password, $db_name);

       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

        if($valueOfEmail == 'collegedeanBA@nu-fairview.edu.ph'){
        $condition = 'user_id = 408 OR user_id = 409 ';
        //408 Accountancy, 409 Business Administration

       }

       else if($valueOfEmail == 'collegedeanET@nu-fairview.edu.ph'){
        $condition = 'user_id = 401 OR user_id = 404 OR user_id = 406';
        //401 IT, 404 Comp Engr., 406 Ins of Civil Engr. 

       } 
       else if($valueOfEmail == 'collegedeanArcht@nu-fairview.edu.ph'){
        $condition = 'user_id = 403';
        //403 Architect

       }
       else if($valueOfEmail == 'collegedeanAS@nu-fairview.edu.ph'){
        $condition = 'user_id = 403';
        //403 Architect

       }            
       else{
        $condition = 'user_id = 99999999';
       }
       


       $sql = "SELECT user_id, activity_title, activity_options, program_organization, date_requested FROM sarf_requests WHERE $condition";
       $result = $conn->query($sql);

       echo "<table>
               <tr>
                   <th class='blankNumber'></th>
                   <th class='name'>Activity Name</th>
                   <th class='type'>Activity Type</th>
                   <th class='orgsName'>Orgs Name</th>
                   <th class='date'>Date</th>
                   <th class='status'>Status</th>
                 
               </tr>";

               $numbering = 1;

       while ($row = $result->fetch_assoc()) {
        $getUserId = $row['user_id']; 
        $sqlCheckLastApprover = "SELECT ed, sad, asd FROM status_of_requests WHERE user_id = $getUserId";
        $resultCheckId = $conn->query($sqlCheckLastApprover);
        $rowResultCheckId = $resultCheckId->fetch_assoc();

        $statusLastApprover = $rowResultCheckId['ed'];
        if($statusLastApprover == 'none'){
            $statusLastApprover = $rowResultCheckId['sad'];
            if($statusLastApprover == 'none'){
                $statusLastApprover = $rowResultCheckId['asd'];
            }
        }
        $ucfirstStatus = ucfirst($statusLastApprover);
           echo "<tr>
                   <td class='numbering'>" . $numbering . "</td>
                   <td class='activity_title'>" . $row["activity_title"] . "</td>
                   <td class='activity_types'>" . $row["activity_options"] . "</td>
                 
                   <td class='program_org' onclick='goToCdStatusProgress(\"" . $row["program_organization"] . "\")'>" . $row["program_organization"] . "</td>
                   <td class='date_req'>" . $row["date_requested"] . "</td>
                   <td class='status'>" . $ucfirstStatus . "</td>
                   
                 </tr>";
                 $numbering++;
       }
       echo "</table>";

       $conn->close();
   ?>

<script>
    function goToCdStatusProgress(programOrganization) {
        var page = 'CdStatusProgresspage.php?org=' + programOrganization;
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

        </div>    
    
</body>
</html>

<?php
} else{
    header("Location: Loginpage.php");
    exit();
}
?>
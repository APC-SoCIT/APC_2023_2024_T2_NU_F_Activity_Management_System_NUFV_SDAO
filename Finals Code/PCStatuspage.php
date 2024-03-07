<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
    include 'db_conn2.php';
    $sqlOrg2 = "SELECT program_chair_program FROM nu_accountsdb.program_chair_approver WHERE program_chair_email = '$valueOfEmail'" ;
    $resultOrg2 = $conn->query($sqlOrg2);

    if (!$resultOrg2) {
        die("Query failed: " . $conn->error);
    }

    $org = "";
    if ($resultOrg2->num_rows > 0) {
        $rowOrg2 = $resultOrg2->fetch_assoc();
        $org = $rowOrg2['program_chair_program'];
        $sourceTable = "program_chair_approver";
    } 
    
?>

    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="CSS/orgadvstatus.css" as="style">
    <link rel="stylesheet" href="CSS/orgadvstatus.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Document</title>
    
</head>
<body>
        <div class="right">
        <div class="title">
                <h1 class="h1Title">ACTIVITY STATUS</h1>
           
            <div class="lineSeparator">
            <p class="reminderText">A streamlined procedure designed to review, authorize, and validate requests, ensuring that they meet predefined criteria or standards, before they are executed or implemented. To access the main page of the activity status, click the text under the orgs name column (Example: Codability)</p>       
            </div>

            </div>
            <div class="Content">
            <div class="innerPageContent">
            <?php

       $sql = "SELECT user_id, activity_title, activity_options, program_organization, date_requested FROM sarf_requests where program_organization = '$org'";
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
                 
                   <td class='program_org' onclick='goToPCStatusProgress(\"" . $row["program_organization"] . "\")'>" . $row["program_organization"] . "</td>
                   <td class='date_req'>" . $row["date_requested"] . "</td>
                   <td class='status'>" . $ucfirstStatus . "</td>
                   
                 </tr>";
                 $numbering++;

       }
       echo "</table>";
       
       $conn->close();
   ?>

   <script>
    function goToPCStatusProgress(programOrg) {
        var page = 'PCStatusProgresspage.php?org=' + programOrg;
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
<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
   

    $sname = "localhost:3307";
        $uname = "root";
        $password = "";
        $db_name = "sarf";

        $conn = new mysqli($sname, $uname, $password, $db_name);

    $sqlOrg = "SELECT org_adviser_program FROM nu_accountsdb.org_adviser_approver WHERE org_adviser_email = '$valueOfEmail'" ;
    $resultOrg = $conn->query($sqlOrg);

    
    $sqlOrg2 = "SELECT program_chair_program FROM nu_accountsdb.program_chair_approver WHERE program_chair_email = '$valueOfEmail'" ;
    $resultOrg2 = $conn->query($sqlOrg2);



    if (!$resultOrg || !$resultOrg2) {
        die("Query failed: " . $conn->error);
    }

    $org = "";
    // Determine the source of the email and set the organization variable accordingly
    if ($resultOrg->num_rows > 0) {
        $rowOrg = $resultOrg->fetch_assoc();
        $org = $rowOrg['org_adviser_program'];
        $sourceTable = "org_adviser_approver";
    } elseif ($resultOrg2->num_rows > 0) {
        $rowOrg2 = $resultOrg2->fetch_assoc();
        $org = $rowOrg2['program_chair_program'];
        $sourceTable = "program_chair_approver";
    } else {
        // Handle the case where the email is not found in either table
        die("Email not found in any table.");
    }
    
?>

    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="CSS/Approval.css" as="style">
    <link rel="stylesheet" href="CSS/Approval.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Document</title>
    
</head>
<body>
        <div class="right">
        <div class="title">
                <h1 class="h1Title">APPROVAL WORKFLOW</h1>
           
            <div class="lineSeparator">
            <p class="reminderText">A streamlined procedure designed to review, authorize, and validate requests, ensuring that they meet predefined criteria or standards, before they are executed or implemented.</p>       
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

       $sql = "SELECT activity_title, activity_options, program_organization, date_requested FROM sarf_requests where program_organization = '$org'";
       $result = $conn->query($sql);

       echo "<table>
               <tr>
                   <th class='blankNumber'></th>
                   <th class='name'>Activity Name</th>
                   <th class='type'>Activity Type</th>
                   <th class='orgsName'>Orgs Name</th>
                   <th class='date'>Date</th>

                 
               </tr>";

               $numbering = 1;

       while ($row = $result->fetch_assoc()) {
           echo "<tr>
                   <td class='numbering'>" . $numbering . "</td>
                   <td class='activity_title'>" . $row["activity_title"] . "</td>
                   <td class='activity_types'>" . $row["activity_options"] . "</td>
                 
                   <td class='program_org' onclick='goToOrgAdvApproval(\"" . $row["program_organization"] . "\")'>" . $row["program_organization"] . "</td>
                   <td class='date_req'>" . $row["date_requested"] . "</td>
                
                   
                 </tr>";
                 $numbering++;

       }
       echo "</table>";
       
       $conn->close();
   ?>

   <script>
    function goToOrgAdvApproval(programOrg) {
        var page = 'OrgAdvApprovalProgresspage.php?org=' + programOrg;
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
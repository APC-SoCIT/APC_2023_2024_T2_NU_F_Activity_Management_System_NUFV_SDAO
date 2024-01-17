<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Approval.css">
    <script src="functions.js"></script>
    <title>Document</title>
</head>
<body>
      <div class="split-background">
     
       

        <div class="right">
        <div class="title">
                <h1 class="h1Title">APPROVAL WORKFLOW</h1>
           
            <div class="lineSeparator">
            <p class="reminderText">A streamlined procedure designed to review, authorize, and validate requests, ensuring that they meet predefined criteria or standards, before they are executed or implemented.</p>
                

            </div>

            </div>
            <div class="Content">
            <?php
       $sname = "localhost:3307";
       $uname = "root";
       $password = "";
       $db_name = "sarf";

       $conn = new mysqli($sname, $uname, $password, $db_name);

       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "SELECT activity_title, activity_types, program_organization, date_requested FROM sarf_requests";
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
           echo "<tr>
                   <td class='numbering'>" . $numbering . "</td>
                   <td class='activity_title'>" . $row["activity_title"] . "</td>
                   <td class='activity_types'>" . $row["activity_types"] . "</td>
                 
                   <td class='program_org' onclick='goToApproval(\"" . $row["program_organization"] . "\")'>" . $row["program_organization"] . "</td>
                   <td class='date_req'>" . $row["date_requested"] . "</td>
                   <td class='status'>" . 'Pending' . "</td>
                   
                 </tr>";
                 $numbering++;
       }
       echo "</table>";

       $conn->close();
   ?>

   <script>
    function goToApproval(programOrganization) {
        var page = 'ApprovalProgresspage.php?org=' + programOrganization;
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
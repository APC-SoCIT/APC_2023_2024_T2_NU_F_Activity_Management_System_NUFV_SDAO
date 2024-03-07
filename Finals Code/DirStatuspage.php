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
    <link rel="stylesheet" href="CSS/dirstatus.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Document</title>
</head>
<body>
        <div class="right">
        <div class="title">
                <h1 class="h1Title">ACTIVITY STATUS</h1>     
            <div class="lineSeparator">
            <p class="reminderText">Activity Status offers a snapshot of ongoing events, showing their progress, completion, or any other pertinent status facilitating efficient management and coordination.</p>

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

       $sqlGetId = "SELECT user_id, ed FROM status_of_requests";
       $resultGetId = $conn->query($sqlGetId);
 

       if($valueOfEmail == 'asdirector@nu-fairview.edu.ph'){
        $varSor = 'sor.asd';
       } else if($valueOfEmail == 'sadirector@nu-fairview.edu.ph'){
        $varSor = 'sor.sad';
       } else if($valueOfEmail == 'edirector@nu-fairview.edu.ph'){
        $varSor = 'sor.ed';
       }
       

     
       
       $sql = "SELECT 
       sr.activity_title, 
       sr.activity_options, 
       sr.program_organization, 
       sr.date_requested,
       sor.ed
   FROM 
       sarf_requests sr
   INNER JOIN 
       status_of_requests sor ON sr.user_id = sor.user_id
   WHERE 
        $varSor = 'pending' OR $varSor = 'approved';";
       

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
                 $activity_title = $row["activity_title"];
                 $activity_options = $row["activity_options"];
                 $program_organization = $row["program_organization"];
                 $date_requested = $row["date_requested"];
                 $valueED = $row["ed"];
                 $ucvalueED = ucwords($valueED);
         
         
                    echo "<tr>
                            <td class='numbering'>" . $numbering . "</td>
                            <td class='activity_title'>" . $activity_title. "</td>
                            <td class='activity_types'>" . $activity_options . "</td>
                          
                            <td class='program_org' onclick='goToDirStatus(\"" . $program_organization . "\")'>" . $row["program_organization"] . "</td>
                            <td class='date_req'>" . $date_requested . "</td>
                            <td class='status'>" . $ucvalueED . "</td>
                   
                            
                          </tr>";
                          $numbering++;
       }
       echo "</table>";

       $conn->close();
   ?>

<script>
    function goToDirStatus(programOrganization) {
        var page = 'DirStatusProgresspage.php?org=' + programOrganization;
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
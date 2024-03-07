<?php

session_start();

$sname = "localhost:3307";
$unmae = "root";
$password = "";
$db_name = "sarf";

$usersDBHost = "localhost:3307";
$usersDBUser = "root";
$usersDBPassword = "";
$usersDBName = "nu_accountsdb";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, $usersDBName);

$user_email = $_SESSION['email'];
$getUserIDQuery = "SELECT id, program_organization FROM studentaccounts WHERE email = '$user_email'";
$result = $conn->query($getUserIDQuery);


// Check if the query was successful
if ($result !== false) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $org_name = $row['program_organization'];
    } else {
        // Handle the case where no rows were found
        echo "No rows found for the user.";
    }
} else {
    // Handle query execution error
    echo "Error executing query: " . $conn->error;
}
$checkID = "SELECT user_id FROM sarf.status_response WHERE user_id = $user_id";
$resultCheckID = $conn->query($checkID);



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $todayDate = date("Y/m/d");
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $dateRequested = $todayDate;
    $programOrganization = $org_name;
    $activityTitle = isset($_POST['activity_title']) ? $_POST['activity_title'] : '';
    $activityDateTime = isset($_POST['activity_datetime']) ? $_POST['activity_datetime'] : '';
    $activityEndDateTime = isset($_POST['activity_end_datetime']) ? $_POST['activity_end_datetime'] : '';
    $activityObjective = isset($_POST['activity_objective']) ? $_POST['activity_objective'] : '';
    $targetParticipants = isset($_POST['target_no_of_participants']) ? $_POST['target_no_of_participants'] : '';

    $activityTypes = isset($_POST['ActivityType']) ? implode(', ', $_POST['ActivityType']) : '';
    $activityOptions = isset($_POST['ActivityOptions']) ? implode(', ', $_POST['ActivityOptions']) : '';
    if ($activityOptions == ''){
        $activityOptions = isset($_POST['others_indicateInclusion']) ? $_POST['others_indicateInclusion'] : '';

    }
    $sdaoOptions = isset($_POST['SDAOOptions']) ? implode(', ', $_POST['SDAOOptions']) : '';
    $specificAmount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $othersIndicate = isset($_POST['others_indicate']) ? $_POST['others_indicate'] : '';
    



    $sql = "INSERT INTO $db_name.sarf_requests (name, date_requested, program_organization, activity_title, activity_datetime, activity_end_datetime, activity_objective, target_participants, activity_types, activity_options, sdao_options, amount, others_indicate, user_id) 
            VALUES ('$name', '$dateRequested', '$programOrganization', '$activityTitle', '$activityDateTime', '$activityEndDateTime', '$activityObjective', '$targetParticipants', '$activityTypes', '$activityOptions', '$sdaoOptions', '$specificAmount', '$othersIndicate', '$user_id')";

    $sqlUpa = "INSERT INTO sarf.status_response(user_id, program_organization, activity_name) VALUES ('$user_id', '$programOrganization', '$activityTitle')";


    $sqlCheckDateTime = "SELECT activity_datetime, activity_end_datetime 
    FROM sarf.sarf_requests 
    WHERE (activity_datetime >= '$activityDateTime' AND activity_end_datetime <= '$activityEndDateTime')
    OR (activity_datetime <= '$activityDateTime' AND activity_end_datetime >= '$activityEndDateTime')
    OR (activity_datetime <= '$activityDateTime' AND activity_end_datetime >= '$activityDateTime')
    OR (activity_datetime <= '$activityEndDateTime' AND activity_end_datetime >= '$activityEndDateTime')";
   
   
   //first combination done -  $4am ( 6am to 8 am) $9am
   //second combination done -   ( 6am $6:05am to $7:05 8am) 
   //third combination done - (6am $6:05am to 8am) $9am
   //fourth combination - $5am (6am to $7am 8am)
$resultDateTime = $conn->query($sqlCheckDateTime);
    

    if($resultCheckID->num_rows > 0){
        echo '<script>
        function popup() {
            alert("You already have a pending request.");
        }
        popup();
        window.location.href = "index.php";    
    </script>';
    } else if ($resultDateTime->num_rows > 0) {
            echo '<script>
                function popupDateTaken() {
                    alert("The chosen date has conflicts.");
                }
                popupDateTaken();
                window.location.href = "index.php";
            </script>';
    } else if ($activityDateTime > $activityEndDateTime){
        echo '<script>
        function popupDate() {
            alert("The end date cannot be earlier than the start date.");
        }
        popupDate();
        window.location.href = "index.php";
      
    </script>';

    } else{
        if ($conn->query($sql) === TRUE && $conn->query($sqlUpa) === TRUE) {
            header("Location: pagetwo.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    
}

$conn->close();
?>
 

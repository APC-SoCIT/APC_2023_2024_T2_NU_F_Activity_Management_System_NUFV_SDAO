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
$getUserIDQuery = "SELECT id FROM studentaccounts WHERE email = '$user_email'";
$result = $conn->query($getUserIDQuery);



// Check if the query was successful
if ($result !== false) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    } else {
        // Handle the case where no rows were found
        echo "No rows found for the user.";
    }
} else {
    // Handle query execution error
    echo "Error executing query: " . $conn->error;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... rest of your code ...
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $dateRequested = isset($_POST['date_requested']) ? $_POST['date_requested'] : '';
    $programOrganization = isset($_POST['program_organization']) ? $_POST['program_organization'] : '';
    $activityTitle = isset($_POST['activity_title']) ? $_POST['activity_title'] : '';
    $activityDateTime = isset($_POST['activity_datetime']) ? $_POST['activity_datetime'] : '';
    $activityObjective = isset($_POST['activity_objective']) ? $_POST['activity_objective'] : '';
    $targetParticipants = isset($_POST['target_no_of_participants']) ? $_POST['target_no_of_participants'] : '';

    $activityTypes = isset($_POST['ActivityType']) ? implode(', ', $_POST['ActivityType']) : '';
    $activityOptions = isset($_POST['ActivityOptions']) ? implode(', ', $_POST['ActivityOptions']) : '';
    $sdaoOptions = isset($_POST['SDAOOptions']) ? implode(', ', $_POST['SDAOOptions']) : '';
    $othersIndicate = isset($_POST['others_indicate']) ? $_POST['others_indicate'] : '';
    



    $sql = "INSERT INTO $db_name.sarf_requests (name, date_requested, program_organization, activity_title, activity_datetime, activity_objective, target_participants, activity_types, activity_options, sdao_options, others_indicate, user_id) 
            VALUES ('$name', '$dateRequested', '$programOrganization', '$activityTitle', '$activityDateTime', '$activityObjective', '$targetParticipants', '$activityTypes', '$activityOptions', '$sdaoOptions', '$othersIndicate', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: pagetwo.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

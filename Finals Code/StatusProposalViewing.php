<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Files</title>
</head>
<body>
<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    // Database connection for nuaccountsdb
    $db_host1 = "localhost";
    $db_user1 = "root";
    $db_pass1 = "";
    $db_name1 = "nu_accountsdb";

    $conn1 = new mysqli($db_host1, $db_user1, $db_pass1, $db_name1);

    if ($conn1->connect_error) {
        die("Connection failed: " . $conn1->connect_error);
    }

    // Retrieve program_organization from the user's account
    $user_email = $_SESSION['email'];
    $sql = "SELECT program_organization FROM studentaccounts WHERE email = '$user_email'";
    $result = $conn1->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $program_organization = $row["program_organization"];

            // Close the connection to nuaccountsdb
            $conn1->close();

            // Database connection for sarf
            $db_host2 = "localhost";
            $db_user2 = "root";
            $db_pass2 = "";
            $db_name2 = "sarf";

            $conn2 = new mysqli($db_host2, $db_user2, $db_pass2, $db_name2);

            if ($conn2->connect_error) {
                die("Connection failed: " . $conn2->connect_error);
            }

            // Retrieve the latest file associated with the program organization from the database
            $sql_files = "SELECT filename FROM activity_proposal WHERE program_organization = '$program_organization' ORDER BY upload_date DESC LIMIT 1";
            $result_files = $conn2->query($sql_files);

            if ($result_files) {
                if ($result_files->num_rows > 0) {
                    $row_files = $result_files->fetch_assoc();
                    $filename = $row_files["filename"];
                    $file_path = "proposal/" . $filename;
                    ?>
                    <h1>Latest File for Program Organization: <?php echo $program_organization; ?></h1>
                    <button onclick="window.open('<?php echo $file_path; ?>', '_blank');">Activity Proposal</button>
                    <?php
                } else {
                    echo "<p>No files found for this program organization.</p>";
                }
            } else {
                echo "<p>Error: " . $conn2->error . "</p>";
            }
            $conn2->close();
        } else {
            echo "<p>Program organization not found for this user.</p>";
        }
    } else {
        echo "<p>Error: " . $conn1->error . "</p>";
    }
} else {
    header("Location: Loginpage.php");
    exit();
}
?>
</body>
</html>

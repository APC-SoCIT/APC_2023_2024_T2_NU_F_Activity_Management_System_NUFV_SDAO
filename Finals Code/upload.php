<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Report</title>
    <link rel="stylesheet" href="CSS/studreport.css">

    <style></style> 
</head>
<body>
    <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
                <ul>
                    <li><a href="StudHomepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>
                    <li><a href="StudSarfpage.php" class="form"><img src="IMG/formIcon2.png" class="formIcon">Request Form</a></li>
                    <li><a href="StudStatuspage.php" class="status"><img src="IMG/statusIcon.png" class="statusIcon">Status</a></li>
                    <li><a href="StudReportspage.php" class="reports"><img src="IMG/reportsIcon.png" class="reportsIcon">End Report</a></li>
                    
                    <div class="outterline">
            <div class="line"></div>
            <div class="buttons">
        <button class="profilebtn"><img src="IMG/profile.png" alt=""></button>

        <button id="logoutbtn" class="lgoutbtn"><img src="IMG/exit.png"></button>
        </div>


            </div>

                </ul>
                    <script>
                        var button = document.getElementById("logoutbtn");
                        button.addEventListener("click", function() {
                            window.location.href = "logout.php";
                        });
                    </script>
                
            </div>
        </div>

        <div class="right">
            <div class="title">
                <h1 class="h1Title">Field End Event Report</h1>
                <div class="lineSeparator"><br><Br><br>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
                            if (isset($_POST["activity_title"])) {
                                $activity_title = $_POST["activity_title"];

                                $sname = "localhost:3307";
                                $uname = "root";
                                $password = "";
                                $db_name = "nu_accountsdb";
                        
                                $conn = new mysqli($sname, $uname, $password, $db_name);

                                $email = $_SESSION['email'];

                                $sqlGetOrg = "SELECT program_organization FROM studentaccounts WHERE email = '$email'";
                                $sqlGetOrgResult = $conn->query($sqlGetOrg);
                                $sqlGetOrgRow = $sqlGetOrgResult->fetch_assoc();
                                $program_organization =$sqlGetOrgRow['program_organization'];

                                
                                $target_dir = "uploads/";
                                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                // Check if the file is allowed
                                $allowed_types = array("pdf");
                                if (!in_array($file_type, $allowed_types)) {
                                    ?>
                                    <h1>File Upload Error</h1>
                                    <p>Sorry, only PDF files are allowed.</p>
                                    <?php
                                } else {
                                    // Move the uploaded file to the specified directory
                                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                                        // File upload success, now store information in the database
                                        $filename = $_FILES["file"]["name"];
                                        $filesize = $_FILES["file"]["size"];
                                        $filetype = $_FILES["file"]["type"];

                                        // Database connection
                                        $db_host = "localhost:3307";
                                        $db_user = "root";
                                        $db_pass = "";
                                        $db_name = "sarf";

                                        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }

                                        // Insert the file information into the database
                                        $sql = "INSERT INTO files (filename, filesize, filetype, activity_title, program_organization) VALUES ('$filename', $filesize, '$filetype', '$activity_title', '$program_organization')";

                                        if ($conn->query($sql) === TRUE) {
                                            ?>
                                            <h1>File Upload Success</h1><br>
                                            <p>The file <?php echo basename($_FILES["file"]["name"]); ?> has been uploaded.</p>
                                            <?php
                                        } else {
                                            ?>
                                            <h1>File Upload Error</h1>
                                            <p>Sorry, there was an error uploading your file <?php echo $conn->error; ?></p>
                                            <?php
                                        }

                                        $conn->close();
                                    } else {
                                        ?>
                                        <h1>File Upload Error</h1>
                                        <p>Sorry, there was an error uploading your file.</p>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <h1>File Upload Error</h1>
                                <p>No activity title was selected.</p>
                                <?php
                            }
                        } else {
                            ?>
                            <h1>File Upload Error</h1>
                            <p>No file was uploaded.</p>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
} else {
    header("Location: Loginpage.php");
    exit();
}
?>

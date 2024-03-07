
<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
    include 'db_conn.php';
    $sqlGetId = "SELECT id, program_organization FROM nu_accountsdb.studentaccounts WHERE email = '$valueOfEmail'";
    $resultGetId = $conn->query($sqlGetId);
    $rowResultGetId = $resultGetId->fetch_assoc();
    $id = $rowResultGetId['id'];
    $org = $rowResultGetId['program_organization'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Proposal</title>

</head>
<body>
    <div class="split-background">
       
        </div>

        <div class="right">
            <div class="title">
                <h1 class="h1Title">Activity Proposal</h1>
                <div class="lineSeparator"><br><Br><br>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
                                $target_dir = "proposal/";
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
                                        $sql = "INSERT INTO activity_proposal (user_id ,program_organization, filename, filesize, filetype, upload_date) VALUES ($id, '$org', '$filename', $filesize, '$filetype', NOW())";

                                        if ($conn->query($sql) === TRUE) {
                                            ?>
                                            <h1>File Upload Success</h1><br>
                                            <p>The file <?php echo basename($_FILES["file"]["name"]); ?> has been uploaded.</p>
                                            <script>
                                                window.location.href = 'StudSarfpage.php';
                                            </script>
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
                                <p>Maximum filesize is 8.38MB</p>
                                <?php
                            }
                        } else {
                            ?>
                            <h1>File Upload Error</h1>
                            <p>No file was uploaded.</p>
                            <?php
                        }
                    
                    ?>
                </div>
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

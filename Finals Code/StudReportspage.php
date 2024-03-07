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
    <link rel="stylesheet" href="CSS/studreport.css">
    <title>End Activity Report</title>

    <style>
        .titleClass{
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
                <ul>
                    <li><a href="StudHomepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>
                    <li><a href="index.php" class="form"><img src="IMG/formIcon2.png" class="formIcon">Request Form</a></li>
                    <li><a href="StudStatuspage.php" class="status"><img src="IMG/statusIcon.png" class="statusIcon">Status</a></li>
                    <li><a href="StudCalendar.php" class="calendar"><img src="IMG/calendarIcon.png" class="calendarIcon">Calendar</a></li>
            
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

<style>
.profilebtn:hover::after {
    content: "<?php echo $valueOfEmail?>";
    position: absolute;
    color: black;
    background-color: white; 
    padding: 5px 5px;
    border-radius: 5px;
    font-size: 14px;
}
    </style>
                
            </div>
        </div>

        <div class="right">
            <div class="title">
                <h1 class="h1Title">Field End Event Report</h1>
                <div class="lineSeparator"><br><Br><br>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="activity_title" class="titleClass">Activity Name</label><br>
                            <select id="activity_title" name="activity_title" required><br>
                                <?php
                                include "db_conn2.php";

                                // Fetch both activity_title and program_organization
                                $sql = "SELECT activity_title, program_organization FROM sarf_requests";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Display activity_title and program_organization as data attributes
                                        echo '<option value="' . $row['activity_title'] . '" data-program-org="' . $row['program_organization'] . '">' . $row['activity_title'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <br><br>

                            <input type="hidden" id="program_organization" name="program_organization">
                            <div class="fileUpload">
                            <label for="file" class="form-label">Upload Attachments</label><br>
                            </div>

                            <div class="fileUpload2">
                            <input type="file" class="form-control" name="file" id="file"><br><br>
                            </div>  
                            
                            
                        </div>
                        <button type="submit" class="btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to set program_organization value based on the selected activity_title
        document.getElementById('activity_title').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var programOrg = selectedOption.dataset.programOrg;
            document.getElementById('program_organization').value = programOrg;
        });
    </script>
</body>
</html>

<?php
} else{
    header("Location: Loginpage.php");
    exit();
}
?>

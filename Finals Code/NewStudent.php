<?php
include "db_conn.php";

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $program = $_POST['program'];
    $program_chair = $_POST['program_chair'];
    $org_adviser = $_POST['org_adviser'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>document.getElementById('emailError').innerHTML = 'Invalid email format. Please enter a valid email address.';</script>";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `studentaccounts`(`id`, `email`,`password`, `program_organization`, `program_chair`, `org_adviser`) VALUES (NULL,'$email','$password','$program','$program_chair','$org_adviser')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: ManageStudent.php");
            exit();
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="CSS/Manage.css">
    <title>Student's Registration</title>
    <script>
        function validateEmail() {
            var emailInput = document.getElementById("email").value;
            var submitButton = document.getElementById("submitBtn");

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput)) {
                submitButton.disabled = true;
                document.getElementById("emailError").innerHTML = "Invalid email format. Please enter a valid email address.";
            } else {
                submitButton.disabled = false;
                document.getElementById("emailError").innerHTML = "";
            }
        }
    </script>
</head>

<body>
<div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
            <ul>
             <li><a href="Homepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>
             <li><a href="ManageAdmin.php" class="status"><img src="" class="statusIcon">Admin Accounts</a></li>
             <li><a href="ManageDirector.php" class="status"><img src="" class="statusIcon">Director Accounts</a></li>
             <li><a href="ManageFacility.php" class="reports"><img src="" class="statusIcon">Facility and Equipment Accounts</a></li>
             <li><a href="ManageDean.php" class="status"><img src="" class="statusIcon">College Dean Accounts</a></li>
             <li><a href="ManagePchair.php" class="status"><img src="" class="statusIcon">Program Chair Accounts</a></li>
             <li><a href="ManageOAdviser.php" class="status"><img src="" class="statusIcon">Organization Adviser Accounts</a></li>
             <li><a href="ManageStudent.php" class="form"><img src="" class="statusIcon">Student Accounts</a></li>
            </ul>

            </div>
        </div>
        <div class="right">
    <div class="pageContent"><br><br>
        <div class="innerpageContent">
            <div class="container">
                <div class="text-center mb-4">
                    <h3>Add New Student</h3>
                    <p class="text-muted">Complete the form below to add a new user</p>
                </div>

                <div class="container d-flex justify-content-center">
                    <form action="" method="post" style="width:50vw; min-width:300px;">

                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="admin@nu-fairview.edu.ph" onblur="validateEmail()" required>
                            <span id="emailError" style="color: red;"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Program Organization:</label>
                            <input type="program" class="form-control" name="program" id="program" placeholder="Program Organization" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Program Chair:</label>
                            <input type="program_chair" class="form-control" name="program_chair" id="program_chair" placeholder="Program Chair" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Organization Adviser:</label>
                            <input type="org_adviser" class="form-control" name="org_adviser" id="org_adviser" placeholder="Organization Adviser" required>
                        </div>


                        <div>
                            <button type="submit" class="btn btn-success" name="submit" id="submitBtn">Add</button>
                            <a href="ManageStudent.php" class="btn btn-danger cancel-btn">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>

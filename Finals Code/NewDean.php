<?php
include "db_conn.php";

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = $_POST['department'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>document.getElementById('emailError').innerHTML = 'Invalid email format. Please enter a valid email address.';</script>";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `college_dean_approver`(`id`, `college_dean_name`,`college_dean_email`, `college_dean_password`, `college_dean_department`) VALUES (NULL,'$name','$email','$password','$department')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: ManageDean.php");
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
    <title>College Dean's Registration</title>
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
             <li><a href="ManageDean.php" class="form"><img src="" class="statusIcon">College Dean Accounts</a></li>
             <li><a href="ManagePchair.php" class="status"><img src="" class="statusIcon">Program Chair Accounts</a></li>
             <li><a href="ManageOAdviser.php" class="status"><img src="" class="statusIcon">Organization Adviser Accounts</a></li>
             <li><a href="ManageStudent.php" class="status"><img src="" class="statusIcon">Student Accounts</a></li>
            </ul>

            </div>
        </div>
        <div class="right">
    <div class="pageContent"><br><br>
        <div class="innerpageContent">
            <div class="container">
                <div class="text-center mb-4">
                    <h3>Add New College Dean</h3>
                    <p class="text-muted">Complete the form below to add a new user</p>
                </div>

                <div class="container d-flex justify-content-center">
                    <form action="" method="post" style="width:50vw; min-width:300px;">

                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="name" class="form-control" name="name" id="name" placeholder="Name"required>
                        </div>

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
                            <label class="form-label">Department:</label>
                            <input type="department" class="form-control" name="department" id="department" placeholder="Department" required>
                        </div>


                        <div>
                            <button type="submit" class="btn btn-success" name="submit" id="submitBtn">Add</button>
                            <a href="ManageDean.php" class="btn btn-danger cancel-btn">Cancel</a>
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

<?php
include "db_conn.php";
$id = $_GET["id"];

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = $_POST['department'];

  
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE `college_dean_approver` SET `college_dean_name`='$name',`college_dean_email`='$email',`college_dean_password`='$password',`college_dean_department`='$department' WHERE id = $id";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: ManageDean.php");
            exit();
        } else {
            echo "Failed: " . mysqli_error($conn);
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
    <title>College Dean's Account</title>
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
        
        <br><br>
    <div class="pageContent">
        <div class="innerpageContent">

            <div class="container">
            <h1 class="heading">College Dean's Account</h1>
                <div class="text-center mb-4">
                    <p class="text-muted">Click update after changing any information</p>
                </div>

                <?php
                $sql = "SELECT * FROM `college_dean_approver` WHERE id = $id LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>

                <div class="container d-flex justify-content-center">
                    <form action="" method="post" style="width:50vw; min-width:300px;">

                    <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="name" class="form-control" name="name" value="<?php echo $row['college_dean_name'] ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $row['college_dean_email'] ?>">
                            <span id="emailError" style="color: red;"></span> <!-- Email error message span -->
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department:</label>
                            <input type="department" class="form-control" name="department" value="<?php echo $row['college_dean_department'] ?>">
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success" name="submit">Update</button>
                            <a href="ManageDean.php" class="btn btn-danger cancel-btn">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>

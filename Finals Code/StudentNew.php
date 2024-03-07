<?php
include "db_conn.php";

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $organizationName = $_POST['name']; 

    $sql = "INSERT INTO `studentaccounts`(`id`, `email`, `password`, `program_organization`) VALUES (NULL,'$email','$password', '$organizationName')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: StudentManage.php");
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
   <link rel="stylesheet" href="CSS/EDN.css">
   <title>Student Organization's Registration</title>
</head>

<body>
<div class="pageContent">
        <div class="innerpageContent">
        <h1 class="heading">Student Organization's Account(Academic)</h1><br><br>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Add New User</h3>
         <p class="text-muted">Complete the form below to add a new user</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="mb-3">
               <label class="form-label">Email:</label>
               <input type="email" class="form-control" name="email" placeholder="student@nu-fairview">
            </div>

            <div class="mb-3">
               <label class="form-label">Password:</label>
               <input type="password" class="form-control" name="password" placeholder="password">
            </div>

            <div class="mb-3">
          <label class="form-label">Organization Name:</label>
          <input type="name" class="form-control" name="name" placeholder="Organization Name">
        </div>


            <div>
               <button type="submit" class="btn btn-success" name="submit">Save</button>
               <a href="Navbarpage.php" class="btn btn-danger">Cancel</a>
            </div>
         </form>
      </div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
<?php
include "db_conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/Manage.css">
  <title>Admin's Account</title>
</head>

<body>
<div class="split-background">
        <div class="left">
            <img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">
            <div class="navbar">
            <ul>
             <li><a href="Homepage.php" class="home"><img src="IMG/homeIcon2.png" class="homeIcon"></img>Home</a></li>
             <li><a href="ManageAdmin.php" class="form"><img src="" class="statusIcon">Admin Accounts</a></li>
             <li><a href="ManageDirector.php" class="status"><img src="" class="statusIcon">Director Accounts</a></li>
             <li><a href="ManageFacility.php" class="reports"><img src="" class="statusIcon">Facility and Equipment Accounts</a></li>
             <li><a href="ManageDean.php" class="reports"><img src="" class="statusIcon">College Dean Accounts</a></li>
             <li><a href="ManagePchair.php" class="status"><img src="" class="statusIcon">Program Chair Accounts</a></li>
             <li><a href="ManageOAdviser.php" class="status"><img src="" class="statusIcon">Organization Adviser Accounts</a></li>
             <li><a href="ManageStudent.php" class="status"><img src="" class="statusIcon">Student Accounts</a></li>
            </ul>

            </div>
        </div>

    <div class="right">
        <div class="title">
            <h1 class="h1Title">ACCOUNT MANAGEMENT</h1>
            <div class="lineSeparator">
                <p class="reminderText">Update personal information, change passwords, set notification preferences, and manage security features, ensuring a tailored and secure experience.</p>
            </div>
        </div>

        <h1 class="heading">Admin Accounts</h1><br>
        <button class="btn-new" onclick="location.href='NewAdmin.php'">Create New</button><br><br>
  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
  


    <table>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      <tbody>
        <?php
        $sql = "SELECT * FROM `admin`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["id"] ?></td>
            <td><?php echo $row["admin_name"] ?></td>
            <td><?php echo $row["admin_email"] ?></td>
            <td>
            <div class="button-container">
         <button class="btn btn-edit" onclick="window.location.href='EditAdmin.php?id=<?php echo $row["id"] ?>'">
            <i class="fa-solid fa-solid fa-trash fs-5"></i>Update
        </button> 
        <?php
        echo "<a href='DeleteAdmin.php?id={$row["id"]}' onclick=\"return confirm('Are you sure to delete this account?');\" class='btn btn-delete' style='text-decoration: none;'>";
        echo "<i class='fa-solid fa-trash fs-5'></i>Delete";
        echo "</a>";
        ?>
    </div>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
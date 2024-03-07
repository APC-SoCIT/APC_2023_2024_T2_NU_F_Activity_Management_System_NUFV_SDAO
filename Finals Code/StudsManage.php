<?php
include "db_conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/manage.css">
  <title>Student Organization's Account</title>
</head>

<body>
    <div class="pageContent">
        <div class="innerpageContent">
        <h1 class="heading">Student Organization's Account(Non-Academic)</h1>
   <p>These accounts are tailored to meet the specific needs of student organizations, allowing them to manage their activities and resources.</p><br><br>
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
    <button class="btn-new" onclick="location.href='StudsNew.php'">Create New</button>


    <table>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Organization Name</th>
          <th>Actions</th>
        </tr>
      <tbody>
        <?php
        $sql = "SELECT * FROM `studentsaccount`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["id"] ?></td>
            <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["program_organization"] ?></td>
            <td>
            <div class="button-container">
         <button class="btn btn-edit" onclick="window.location.href='StudsEdit.php?id=<?php echo $row["id"] ?>'">
            <i class="fa-solid fa-solid fa-trash fs-5"></i>Update
        </button> 
        <?php
        echo "<a href='StudsDelete.php?id={$row["id"]}' onclick=\"return confirm('Are you sure to delete this account?');\" class='btn btn-delete' style='text-decoration: none;'>";
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

  <!--
  <div class="nbBtn">
        <button onclick="onBack()" class="BACK">Back</button>
        <button onclick="onNext()" class="NEXT">Next</button>
    </div>
      -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>



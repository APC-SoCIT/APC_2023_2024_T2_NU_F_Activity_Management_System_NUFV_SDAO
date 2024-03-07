<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `college_dean_approver` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: ManageDean.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
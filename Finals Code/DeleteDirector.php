<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `directors_approver` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: ManageDirector.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
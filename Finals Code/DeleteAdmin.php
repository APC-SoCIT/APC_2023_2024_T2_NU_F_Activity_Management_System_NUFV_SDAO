<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `accountstbl` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: ManageAdmin.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
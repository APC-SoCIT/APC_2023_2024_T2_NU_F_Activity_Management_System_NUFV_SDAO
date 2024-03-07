<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `studentsaccount` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: StudsManage.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
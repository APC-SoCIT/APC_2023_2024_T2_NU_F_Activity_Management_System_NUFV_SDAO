<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `studentaccounts` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: StudentManage.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
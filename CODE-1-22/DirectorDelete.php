<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `diraccounts` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: DirectorManage.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
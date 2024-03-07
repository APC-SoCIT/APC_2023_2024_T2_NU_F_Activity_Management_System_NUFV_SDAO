<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `program_chair_approver` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: ManagePchair.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
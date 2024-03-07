<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `facilities_and_equipment_approver` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: ManageFacility.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}

?>
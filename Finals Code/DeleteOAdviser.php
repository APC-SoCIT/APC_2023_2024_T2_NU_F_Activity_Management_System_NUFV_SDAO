<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `org_adviser_approver` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: ManageOAdviser.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
<?php
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `approveraccounts` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: NavbarPage.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>
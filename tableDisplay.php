<?php
// Start the session (if needed)
// session_start();

// Check if the user is logged in (if needed)
// if (!isset($_SESSION['user'])) {
//     header("Location: login.php"); // Redirect to login page
//     exit();
// }

$sname = "localhost:3307";
$uname = "root";
$password = "";
$db_name = "nu_accountsdb";

// Create connection
$conn = new mysqli($sname, $uname, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select data from the 'diraccounts' table
$sql = "SELECT email, password FROM diraccounts";
$result = $conn->query($sql);

// Start HTML table
echo "<table border='1'>
        <tr>
            <th>Email</th>
            <th>Password</th>
        </tr>";

// Output data of each row
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row["email"] . "</td>
            <td>" . $row["password"] . "</td>
          </tr>";
}

// End HTML table
echo "</table>";

// Close the connection
$conn->close();
?>

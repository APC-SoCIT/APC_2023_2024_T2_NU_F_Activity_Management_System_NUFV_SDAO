<?php
session_start();

// Check if the form was successfully submitted
if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
    echo "Form Submitted Successfully";
    // Clear the session variable to avoid displaying the message on subsequent visits
    unset($_SESSION['form_submitted']);
} else {
    // Redirect to another page or show an error message if accessed directly
    header("Location: index.php");
    exit();
}
?>

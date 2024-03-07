<?php
session_start();

// Check if the form was successfully submitted
if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
    echo "Form Submitted Successfully";
    // Unset the session variable
    unset($_SESSION['form_submitted']);
} else {
    // Redirect to another page or show an error message if accessed directly
    header("Location: StudentProposal.php");
    exit();
}
?>
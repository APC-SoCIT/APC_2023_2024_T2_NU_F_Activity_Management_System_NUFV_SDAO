<?php
session_start();

include "db_conn.php";

if(isset($_POST['email']) && isset($_POST['password'])){
    
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $emailVar = validate($_POST['email']);
    $passVar = validate($_POST['password']);
    $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `accountstbl` WHERE email='$emailVar'");
    $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `accountstbl` WHERE password='$passVar'");

    if(empty($emailVar)){
        header("Location: index.php?error=Email is required");
        exit();
    }else if(empty($passVar)){
        header("Location: index.php?error=Password is required");
        exit();
    } else if(mysqli_num_rows($ifexistingEMAIL) == 0) {
        header("Location: index.php?error=Register your account first.");
        exit();
    } else{
        $sql = "SELECT * FROM accountstbl WHERE email='$emailVar' AND password='$passVar'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)===1){
            $row = mysqli_fetch_assoc($result);
            if($row['email'] === $emailVar && $row['password'] === $passVar ){
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password']; 
                header("Location: Homepage.php");
            exit();
            }
        }else {
            header("Location: index.php?error= No account matches with the given email and password. Double-check your campus and account credentials.");
            exit();
        }
    }
}else{
    header("Location: index.php");
    exit();
}

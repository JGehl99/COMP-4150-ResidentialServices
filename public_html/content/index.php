<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'Index';
    include('headers.php');
    ?>
    <meta name="title" content="Home">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
</head>

<?php
    if($_SESSION['account_type'] == "Hall Manager" || $_SESSION['account_type'] == "Administrative Assistant"){
        include('admin_index.php');
    } else if($_SESSION['account_type'] == "Cleaner"){
        include('cleaner_index.php');
    } else if($_SESSION['account_type'] == "Student"){
        include('student_index.php');
    } else{
        header("Location: https://residentialservices.gehlj.myweb.cs.uwindsor.ca/content/login.php");
        exit();
    }
?>
</html>
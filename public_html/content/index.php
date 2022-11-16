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

<body class="page-background">
<?php include('navbar.php'); ?>
<?if(isAdminUser()) {
    include('admin_index.php');
}
else {
    include('student_index.php');
}?>
<?php include('footer.php'); ?>
</body>
</html>
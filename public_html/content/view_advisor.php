<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View Advisor';
    include('headers.php');
    ?>
    <meta name="title" content="Home">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
</head>

<body class="vh-100">
<?php include('studentnav.php'); ?>
<div class="yellow_bg container-fluid yellow_bg h-100">
    <div class="p-5"></div>
    <div class="pt-3 row justify-content-center">
        <div class="col-10 blue_bg container-fluid vh-75 rounded-3">
            <div class="row justify-content-center">
                <div class="card container-fluid p-2 m-3 w-auto">
                    <div class="card-title text-center fs-2">
                        Advisor
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php
                $username = $_SESSION['username'];
                $sql = "SELECT FULL_NAME, POSITION, DEPARTMENT, EXTENSION, OFFICE_NUMBER FROM STUDENT_ADVISOR WHERE EMPLOYEE_ID = (SELECT ADVISOR FROM STUDENT WHERE USERNAME = ?)";

                // create connection
                $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

                // check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                echo "<div class='card-title text-center fs-2'> Name: ". $result["FULL_NAME"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Position: ". $result["POSITION"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Department: ". $result["DEPARTMENT"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Extension: ". $result["EXTENSION"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Office Number: ". $result["OFFICE_NUMBER"]. "</div>";

                $stmt->close();
                $conn->close();

                ?>
            </div>
        </div>
    </div>
</div>
</body>
<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View Lease';
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
                        Lease
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php
                $username = $_SESSION['username'];
                $sql1 = "SELECT ADDRESS, TYPE FROM LOCATED_AT WHERE LOC_ID = (SELECT PLACE_NUMBER FROM LEASES WHERE STUDENT = (SELECT GRADE_12_NUMBER FROM STUDENT WHERE USERNAME = ?))";
                $sql2 = "SELECT RENT_RATE FROM ROOMS WHERE PLACE_NUMBER = (SELECT PLACE_NUMBER FROM LEASES WHERE STUDENT = (SELECT GRADE_12_NUMBER FROM STUDENT WHERE USERNAME = ?))";
                $sql3 = "SELECT PLACE_NUMBER, ENTER_DATE, EXIT_DATE FROM LEASES WHERE STUDENT = (SELECT GRADE_12_NUMBER FROM STUDENT WHERE USERNAME = ?)";

                // create connection
                $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

                // check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare($sql1);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                echo "<div class='card-title text-center fs-2'> Location: ". $result["ADDRESS"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Type: ". $result["TYPE"]. "</div>";

                $stmt = $conn->prepare($sql2);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                echo "<div class='card-title text-center fs-2'> Rent rate: ". $result["RENT_RATE"]. "</div>";

                $stmt = $conn->prepare($sql3);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                echo "<div class='card-title text-center fs-2'> Place #: ". $result["PLACE_NUMBER"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Enter date: ". $result["ENTER_DATE"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Exit date: ". $result["EXIT_DATE"]. "</div>";

                $stmt->close();
                $conn->close();

                ?>
            </div>
        </div>
    </div>
</div>
</body>
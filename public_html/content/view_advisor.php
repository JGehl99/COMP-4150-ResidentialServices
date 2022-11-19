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
            <table class="w-100 table bg-white rounded-3">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">Department</th>
                        <th scope="col">Extension</th>
                        <th scope="col">Office Number</th>
                    </tr>
                </thead>
                <tbody>
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

                echo "<tr>";

                echo "<td>" . $result["FULL_NAME"] . "</td>";
                echo "<td>" . $result["POSITION"] . "</td>";
                echo "<td>" . $result["DEPARTMENT"] . "</td>";
                echo "<td>" . $result["EXTENSION"] . "</td>";
                echo "<td>" . $result["OFFICE_NUMBER"] . "</td>";

                echo "</tr>";
                $stmt->close();
                $conn->close();

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
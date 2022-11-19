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
            <table class="w-100 table bg-white rounded-3">
                <thead>
                    <tr>
                        <th scope="col">Location</th>
                        <th scope="col">Type</th>
                        <th scope="col">Rent Rate</th>
                        <th scope="col">Place #</th>
                        <th scope="col">Enter Date</th>
                        <th scope="col">Exit Date</th>
                    </tr>
                </thead>
                <tbody>
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

                $results = $stmt->get_result();
                while ($result= $results->fetch_assoc()) {
                    echo "<tr>";

                    echo "<td>" . $result["ADDRESS"] . "</td>";
                    echo "<td>" . $result["TYPE"] . "</td>";
                }

                $stmt = $conn->prepare($sql2);
                $stmt->bind_param("s", $username);
                $stmt->execute();

                $results = $stmt->get_result();
                while ($result= $results->fetch_assoc()) {

                    echo "<td>" . $result["RENT_RATE"] . "</td>";
                }

                $stmt = $conn->prepare($sql3);
                $stmt->bind_param("s", $username);
                $stmt->execute();

                $results = $stmt->get_result();
                while ($result= $results->fetch_assoc()) {

                    echo "<td>" . $result["PLACE_NUMBER"]. "</td>";
                    echo "<td>" . $result["ENTER_DATE"] . "</td>";
                    echo "<td>" . $result["EXIT_DATE"] . "</td>";

                    echo "</tr>";
                }

                $stmt->close();
                $conn->close();

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View Flats';
    include('headers.php');
    ?>
    <meta name="title" content="Home">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
</head>

<body class="vh-100">
<?php include('cleanernav.php'); ?>
<div class="yellow_bg container-fluid yellow_bg h-100">
    <div class="p-5"></div>
    <div class="pt-3 row justify-content-center">
        <div class="col-10 blue_bg container-fluid vh-75 col-11 col-md-8 rounded-3">
            <div class="row justify-content-center">
                <div class="container-fluid p-2 m-3 col-md-8 col-11">
                    <div class="text-white text-center fs-2">
                        Student Flats
                    </div>
                </div>
            </div>
            <table class="w-100 table bg-white rounded-3">
                <thead>
                    <tr>
                        <th scope="col">Flat ID</th>
                        <th scope="col">Address</th>
                        <th scope="col"># of Rooms</th>
                        <th scope="col"># of Inspections</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT F.FLAT_ID, L.ADDRESS, F.NUMBER_OF_ROOMS, (SELECT COUNT(*) FROM FLAT_INSPECTIONS AS FI WHERE F.FLAT_ID=FI.FLAT_ID) AS INSPECTION_COUNT FROM STUDENT_FLATS AS F, LOCATED_AT AS L WHERE F.FLAT_LOCATION=L.LOC_ID;";

                // create connection
                $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

                // check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->get_result();
                while ($result= $results->fetch_assoc()) {
                    echo "<tr>";

                    echo "<td>" . $result['FLAT_ID'] . "</td>";
                    echo "<td>" . $result['ADDRESS'] . "</td>";
                    echo "<td>" . $result['NUMBER_OF_ROOMS'] . "</td>";
                    echo "<td>" . $result['INSPECTION_COUNT'] . "</td>";

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
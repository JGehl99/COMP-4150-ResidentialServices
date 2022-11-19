<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View Inspections';
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
                        Inspections
                    </div>
                </div>
            </div>
            <table class="w-100 table bg-white rounded-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Staff</th>
                        <th scope="col">Date</th>
                        <th scope="col">Flat ID</th>
                        <th scope="col">Results</th>
                        <th scope="col">Additional Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT F.INSPECTION_ID, S.FULL_NAME, F.DATE_OF_INSPECTION, F.FLAT_ID, F.INSPECTION_RESULTS, F.ADDITIONAL_COMMENTS FROM FLAT_INSPECTIONS AS F, HOSTEL_STAFF AS S WHERE S.STAFF_NUMBER=F.STAFF_NUMBER;";
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

                        if($_GET['id'] == $result['INSPECTION_ID']){
                            echo "<tr class='highlight'>";
                        } else{
                            echo "<tr>";
                        }

                        echo "<td>" . $result['INSPECTION_ID'] . "</td>";
                        echo "<td>" . $result['FULL_NAME'] . "</td>";
                        echo "<td>" . $result['DATE_OF_INSPECTION'] . "</td>";
                        echo "<td>" . $result['FLAT_ID'] . "</td>";
                        echo "<td>" . $result['INSPECTION_RESULTS'] . "</td>";
                        echo "<td>" . $result['ADDITIONAL_COMMENTS'] . "</td>";

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
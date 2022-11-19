<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View Invoices';
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
                        Invoice
                    </div>
                </div>
            </div>
            <table class="w-100 table bg-white rounded-3">
                <thead>
                    <tr>
                        <th scope="col">Invoice #</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Payment due date</th>
                        <th scope="col">Date paid</th>
                        <th scope="col">First Reminder</th>
                        <th scope="col">Second Reminder</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $username = $_SESSION['username'];
                $sql = "SELECT INVOICE_NUMBER, SEMESTER, PAYMENT_DUE, PAY_DATE, FIRST_REMINDER, SECOND_REMINDER FROM INVOICES WHERE LEASE_NUMBER = (SELECT LEASE_NUMBER FROM LEASES WHERE STUDENT = (SELECT GRADE_12_NUMBER FROM STUDENT WHERE USERNAME = ?))";

                // create connection
                $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

                // check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();

                $results = $stmt->get_result();
                while ($result= $results->fetch_assoc()) {
                    echo "<tr>";

                    echo "<td>" . $result["INVOICE_NUMBER"] . "</td>";
                    echo "<td>" . $result["SEMESTER"] . "</td>";
                    echo "<td>" . $result["PAYMENT_DUE"] . "</td>";
                    if (empty($result["PAY_DATE"])) {  echo "<td> -- -- --</td>"; }
                    else {echo "<td>" . $result["PAY_DATE"] . "</td>";}
                    echo "<td>" . $result["FIRST_REMINDER"] . "</td>";
                    echo "<td>" . $result["SECOND_REMINDER"] . "</td>";

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
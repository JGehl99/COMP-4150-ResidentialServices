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
            <div class="row justify-content-center">
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
                $result = $stmt->get_result()->fetch_assoc();

                echo "<div class='card-title text-center fs-2'> Invoice Number: ". $result["INVOICE_NUMBER"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Semester: ". $result["SEMESTER"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Payment due on: ". $result["PAYMENT_DUE"]. "</div>";
                if (empty($result["PAY_DATE"])) {  echo "<div class='card-title text-center fs-2'>Not paid!</div>"; }
                else {echo "<div class='card-title text-center fs-2'> Paid on: ". $result["PAY_DATE"]. "</div>";}
                echo "<div class='card-title text-center fs-2'> First reminder on: ". $result["FIRST_REMINDER"]. "</div>";
                echo "<div class='card-title text-center fs-2'> Second reminder on: ". $result["SECOND_REMINDER"]. "</div>";

                $stmt->close();
                $conn->close();

                ?>
            </div>
        </div>
    </div>
</div>
</body>
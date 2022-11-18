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
                $sql = "SELECT FULL_NAME, POSITION, DEPARTMENT, EXTENSION, OFFICE_NUMBER FROM STUDENT_ADVISOR WHERE STAFF_NUMBER = (SELECT ADVISOR FROM STUDENT WHERE USERNAME = '$username')";

                // create connection
                $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

                // check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                echo $result;

                $stmt->close();
                $conn->close();

                ?>
            </div>
        </div>
    </div>
</div>
</body>
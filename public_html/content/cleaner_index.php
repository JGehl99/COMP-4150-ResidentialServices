<body class="vh-100">
<?php include('cleanernav.php'); ?>
<div class="yellow_bg container-fluid yellow_bg h-100">
    <div class="p-5"></div>
    <div class="pt-3 row justify-content-center">
        <div class="col-10 blue_bg container-fluid vh-75 rounded-3">
            <div class="row justify-content-center">
                <div class="card container-fluid p-2 m-3 w-auto">
                    <div class="card-title text-center fs-2">
                        Cleaning Services
                        <?php
                        $username = $_SESSION['username'];
                        $sql0 = "SELECT FULL_NAME FROM HOSTEL_STAFF WHERE username =?";

                        // create connection
                        $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

                        // check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $stmt = $conn->prepare($sql0);
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $firstName = explode(" ", $result['FULL_NAME']);

                        echo "<br> Hello, ". $firstName[0];
                        ?>
                    </div>
                </div>
            </div>
            <table class="w-100 table bg-white rounded-3">
                <thead>
                <tr>
                    <th scope="col">Staff Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Home Address</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Position</th>
                    <th scope="col">Location</th>
                    <th scope="col">Can Retire?</th>
                </tr>
                </thead>
                <tbody>
                <?php
                date_default_timezone_set('EST');

                $username = $_SESSION['username'];
                $sql = "SELECT * FROM HOSTEL_STAFF WHERE username =?";
                $sql2 = "SELECT ADDRESS FROM LOCATED_AT WHERE LOC_ID = (SELECT STAFF_LOCATION FROM HOSTEL_STAFF WHERE username =?)";

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
                echo "<td>" . $result["STAFF_NUMBER"] . "</td>";
                echo "<td>" . $result["FULL_NAME"] . "</td>";
                echo "<td>" . $result["HOME_ADDRESS"] . "</td>";
                echo "<td>" . $result["DOB"] . "</td>";
                echo "<td>" . $result["GENDER"] . "</td>";
                echo "<td>" . $result["POSITION"] . "</td>";

                $YOB = explode("-", $result["DOB"]);
                $age = date("Y") - $YOB[0];

                $stmt = $conn->prepare($sql2);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                echo "<td>" . $result["ADDRESS"] . "</td>";
                if($age > 65) {echo "<td> Yes </td>";}
                else {echo "<td> No </td>";}
                echo "</tr>";

                $stmt->close();
                $conn->close();
                ?>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="btn-group-vertical col-6 mb-5 rounded-3">
                    <a type="button" href="view_flats.php" class="btn btn-primary mb-2 rounded-3">View Student Flats</a>
                    <a type="button" href="view_inspections.php" class="btn btn-primary mb-2 rounded-3">View Inspections</a>
                    <a type="button" href="add_inspection.php" class="btn btn-primary mb-2 rounded-3">Add Inspection</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
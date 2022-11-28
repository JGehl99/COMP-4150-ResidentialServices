<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View/Edit Hostel Staff';
    include('headers.php');
    ?>
    <meta name="title" content="Home">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
</head>

<body class="yellow_bg vh-100">
<?php include('adminnav.php'); ?>
<div class="container-fluid yellow_bg h-100">
    <div class="p-4"></div>
    <div class="pt-3 pb-1 justify-content-center">
        <div class="blue_bg container-fluid rounded-3">
            <div class="row justify-content-center">
                <div class="card container-fluid p-2 m-3 w-auto">
                    <div class="card-title text-center fs-2">
                        Hostel Staff
                    </div>
                </div>
            </div>
            <div class="tableFixHead">
                <table class="w-100 table table-striped bg-white">
                    <thead>
                    <tr>
                        <th scope="col">STAFF_NUMBER</th>
                        <th scope="col">FULL_NAME</th>
                        <th scope="col">HOME_ADDRESS</th>
                        <th scope="col">DOB</th>
                        <th scope="col">GENDER</th>
                        <th scope="col">POSITION</th>
                        <th scope="col">STAFF_LOCATION</th>
                        <th scope="col">USERNAME</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // create connection
                    $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

                    // check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (!empty($_POST['full_name']) && !empty($_POST['home_addr']) && !empty($_POST['dob']) &&
                            !empty($_POST['gender']) && !empty($_POST['position']) && !empty($_POST['staff_loc']) &&
                            !empty($_POST['username']) && !empty($_POST['password'])) {
                            if (!empty($_POST['staff_num'])) {
                                $staff_num = intval($_POST['staff_num']);
                            } else {
                                $staff_num = -1;
                            }

                            $full_name = trim($_POST['full_name']);
                            $home_addr = trim($_POST['home_addr']);
                            $dob = trim($_POST['dob']);
                            $gender = trim($_POST['gender']);
                            $position = trim($_POST['position']);
                            $staff_loc = intval($_POST['staff_loc']);
                            $username = trim($_POST['username']);
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


                            // Check to see if that location exists
                            $sql = "SELECT 1 FROM HOSTEL_STAFF WHERE STAFF_NUMBER=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $staff_num);
                            $stmt->execute();
                            $result = $stmt->get_result()->fetch_assoc();

                            $stmt->close();

                            if (is_null($result)) {
                                $sql = "INSERT INTO HOSTEL_STAFF(FULL_NAME, HOME_ADDRESS, DOB, GENDER, POSITION, STAFF_LOCATION, username, password) VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("sssssiss", $full_name, $home_addr, $dob, $gender, $position, $staff_loc, $username, $password);
                            } else {
                                $sql = "UPDATE HOSTEL_STAFF SET FULL_NAME=?, HOME_ADDRESS=?, DOB=?, GENDER=?, POSITION=?, STAFF_LOCATION=?, username=?, password=? WHERE STAFF_NUMBER=?;";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("sssssissi", $full_name, $home_addr, $dob, $gender, $position, $staff_loc, $username, $password, $staff_num);
                            }

                            if (!$stmt->execute()) {
                                echo $conn->error;

                                $msg = "<p class=\"text-danger\">Error, please try again!</p>";
                            } else {
                                $id = mysqli_insert_id($conn);
                            }
                            $stmt->close();
                        }
                    }

                    $sql = "SELECT * FROM HOSTEL_STAFF";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $results = $stmt->get_result();
                    while ($result = $results->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>" . $result["STAFF_NUMBER"] . "</td>";
                        echo "<td>" . $result["FULL_NAME"] . "</td>";
                        echo "<td>" . $result["HOME_ADDRESS"] . "</td>";
                        echo "<td>" . $result["DOB"] . "</td>";
                        echo "<td>" . $result["GENDER"] . "</td>";
                        echo "<td>" . $result["POSITION"] . "</td>";
                        echo "<td>" . $result["STAFF_LOCATION"] . "</td>";
                        echo "<td>" . $result["username"] . "</td>";

                        echo "</tr>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="blue_bg container-fluid rounded-3">
                <div class="row justify-content-center">
                    <div class="container-fluid w-auto">
                        <div class="text-white text-center fs-2">
                            Add/Edit Hostel Staff
                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <form class="container d-flex justify-content-center p-2 col-12" method="post"
                          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-row col-12 rounded p-2">
                            <?php if (!empty($msg)) echo $msg; ?>
                            <div class="form-floating p-1">
                                <input type="number" class="form-control" name="staff_num"
                                       id="floatingTextarea"></input>
                                <label for="floatingTextarea">Staff Number</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="full_name" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Full Name</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="home_addr" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Home Address</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="dob" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Date of Birth</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="gender" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Gender</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="position" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Position</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="staff_loc" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Staff Location</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="username" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Username</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="password" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Password</label>
                            </div>
                            <div class="p-1" id="button_div">
                                <button type="submit" class="btn btn-primary float-end" id="submit_button"
                                        name="submit_button">Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
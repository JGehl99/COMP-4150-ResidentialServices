<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View/Edit Residence Halls';
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
                        Residence Halls
                    </div>
                </div>
            </div>
            <div class="tableFixHead">
                <table class="w-100 table table-striped bg-white">
                    <thead>
                    <tr>
                        <th scope="col">RES_ID</th>
                        <th scope="col">HALL_NAME</th>
                        <th scope="col">HALL_LOCATION</th>
                        <th scope="col">TEL_NUMBER</th>
                        <th scope="col">HALL_MANAGER</th>
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
                        if (!empty($_POST['hall_name']) && !empty($_POST['hall_loc']) && !empty($_POST['tel_num']) && !empty($_POST['hall_mgr'])) {
                            if(!empty($_POST['res_id'])) {
                                $res_id = intval($_POST['res_id']);
                            } else {
                                $res_id = -1;
                            }

                            $hall_name = trim($_POST['hall_name']);
                            $hall_loc = intval($_POST['hall_loc']);
                            $tel_num = trim($_POST['tel_num']);
                            $hall_mgr = intval($_POST['hall_mgr']);


                            // Check to see if that location exists
                            $sql = "SELECT 1 FROM RESIDENCE_HALLS WHERE RES_ID=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $res_id);
                            $stmt->execute();
                            $result = $stmt->get_result()->fetch_assoc();

                            $stmt->close();

                            if (is_null($result)) {
                                $sql = "INSERT INTO RESIDENCE_HALLS(HALL_NAME, HALL_LOCATION, TEL_NUMBER, HALL_MANAGER) VALUES(?, ?, ?, ?);";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("sisi", $hall_name, $hall_loc, $tel_num, $hall_mgr);
                            } else {
                                $sql = "UPDATE RESIDENCE_HALLS SET HALL_NAME=?, HALL_LOCATION=?, TEL_NUMBER=?, HALL_MANAGER=? WHERE RES_ID=?;";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("sisii", $hall_name, $hall_loc, $tel_num, $hall_mgr, $res_id);
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

                    $sql = "SELECT * FROM RESIDENCE_HALLS ";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $results = $stmt->get_result();
                    while ($result = $results->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>" . $result["RES_ID"] . "</td>";
                        echo "<td>" . $result["HALL_NAME"] . "</td>";
                        echo "<td>" . $result["HALL_LOCATION"] . "</td>";
                        echo "<td>" . $result["TEL_NUMBER"] . "</td>";
                        echo "<td>" . $result["HALL_MANAGER"] . "</td>";

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
                            Add/Edit Residence Hall
                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <form class="container d-flex justify-content-center p-2 col-12" method="post"
                          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-row col-12 rounded p-2">
                            <?php if (!empty($msg)) echo $msg; ?>
                            <div class="form-floating p-1">
                                <input type="number" class="form-control" name="res_id" id="floatingTextarea"></input>
                                <label for="floatingTextarea">ID</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="hall_name" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Hall Name</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="hall_loc" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Hall Location</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="tel_num" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Telephone Number</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="hall_mgr" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Hall Manager</label>
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
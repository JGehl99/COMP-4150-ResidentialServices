<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View/Edit Rooms';
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
                        Rooms
                    </div>
                </div>
            </div>
            <div class="tableFixHead">
                <table class="w-100 table table-striped bg-white">
                    <thead>
                    <tr>
                        <th scope="col">PLACE_NUMBER</th>
                        <th scope="col">LOCATION</th>
                        <th scope="col">ROOM_NUMBER</th>
                        <th scope="col">RENT_RATE</th>
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
                        if (!empty($_POST['loc']) && !empty($_POST['room']) && !empty($_POST['rent'])) {
                            if(!empty($_POST['p_num'])) {
                                $p_num = intval($_POST['p_num']);
                            } else {
                                $p_num = -1;
                            }

                            $loc = intval($_POST['loc']);
                            $room = intval($_POST['room']);
                            $rent = intval($_POST['rent']);

                            // Check to see if that location exists
                            $sql = "SELECT 1 FROM ROOMS WHERE PLACE_NUMBER=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $p_num);
                            $stmt->execute();
                            $result = $stmt->get_result()->fetch_assoc();

                            $stmt->close();

                            if (is_null($result)) {
                                $sql = "INSERT INTO ROOMS(LOCATION, ROOM_NUMBER, RENT_RATE) VALUES(?, ?, ?);";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("iii", $loc, $room, $rent);
                            } else {
                                $sql = "UPDATE ROOMS SET LOCATION=?, ROOM_NUMBER=?, RENT_RATE=? WHERE PLACE_NUMBER=?;";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("iiii", $loc, $room, $rent, $p_num);
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

                    $sql = "SELECT * FROM ROOMS";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $results = $stmt->get_result();
                    while ($result = $results->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>" . $result["PLACE_NUMBER"] . "</td>";
                        echo "<td>" . $result["LOCATION"] . "</td>";
                        echo "<td>" . $result["ROOM_NUMBER"] . "</td>";
                        echo "<td>" . $result["RENT_RATE"] . "</td>";

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
                            Add/Edit Rooms
                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <form class="container d-flex justify-content-center p-2 col-12" method="post"
                          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-row col-12 rounded p-2">
                            <?php if (!empty($msg)) echo $msg; ?>
                            <div class="form-floating p-1">
                                <input type="number" class="form-control" name="p_num" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Place Number</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="loc" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Location</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="room" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Room Number</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="rent" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Rent Rate</label>
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
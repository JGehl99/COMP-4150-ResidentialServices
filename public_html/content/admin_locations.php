<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View/Edit Locations';
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
                        Locations
                    </div>
                </div>
            </div>
            <div class="tableFixHead">
                <table class="w-100 table table-striped bg-white">
                    <thead>
                    <tr>
                        <th scope="col">LOC_ID</th>
                        <th scope="col">ADDRESS</th>
                        <th scope="col">TYPE</th>
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
                        if (!empty($_POST['address']) && !empty($_POST['type'])) {
                            if(!empty($_POST['loc_id'])) {
                                $loc_id = intval($_POST['loc_id']);
                            } else {
                                $loc_id = -1;
                            }

                            $addr = trim($_POST['address']);
                            $type = trim($_POST['type']);


                            // Check to see if that location exists
                            $sql = "SELECT 1 FROM LOCATED_AT WHERE LOC_ID=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $loc_id);
                            $stmt->execute();
                            $result = $stmt->get_result()->fetch_assoc();

                            $stmt->close();

                            if (is_null($result)) {
                                $sql = "INSERT INTO LOCATED_AT(ADDRESS, TYPE) VALUES(?, ?);";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("ss", $addr, $type);
                            } else {
                                $sql = "UPDATE LOCATED_AT SET ADDRESS=?, TYPE=? WHERE LOC_ID=?;";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("ssi", $addr, $type, $loc_id);
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

                    $sql = "SELECT * FROM LOCATED_AT";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $results = $stmt->get_result();
                    while ($result = $results->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>" . $result["LOC_ID"] . "</td>";
                        echo "<td>" . $result["ADDRESS"] . "</td>";
                        echo "<td>" . $result["TYPE"] . "</td>";

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
                            Add/Edit Location
                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <form class="container d-flex justify-content-center p-2 col-12" method="post"
                          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-row col-12 rounded p-2">
                            <?php if (!empty($msg)) echo $msg; ?>
                            <div class="form-floating p-1">
                                <input type="number" class="form-control" name="loc_id" id="floatingTextarea"></input>
                                <label for="floatingTextarea">ID</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="address" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Address</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="type" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Type</label>
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
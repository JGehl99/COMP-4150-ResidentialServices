<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View/Edit Flat Inspections';
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
                        Flat Inspections
                    </div>
                </div>
            </div>
            <div class="tableFixHead">
                <table class="w-100 table table-striped bg-white">
                    <thead>
                    <tr>
                        <th scope="col">INSPECTION_ID</th>
                        <th scope="col">STAFF_NUMBER</th>
                        <th scope="col">DATE_OF_INSPECTION</th>
                        <th scope="col">FLAT_ID</th>
                        <th scope="col">INSPECTION_RESULTS</th>
                        <th scope="col">ADDITIONAL_COMMENTS</th>
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
                        if (!empty($_POST['staff_num']) && !empty($_POST['doi']) && !empty($_POST['flat_id']) && !empty($_POST['insp_res']) && !empty($_POST['add_comm'])) {
                            if(!empty($_POST['insp_id'])) {
                                $insp_id = intval($_POST['insp_id']);
                            } else {
                                $insp_id = -1;
                            }

                            $staff_num = intval($_POST['staff_num']);
                            $doi = trim($_POST['doi']);
                            $flat_id = intval($_POST['flat_id']);
                            $insp_res = trim($_POST['insp_res']);
                            $add_comm = trim($_POST['add_comm']);


                            // Check to see if that location exists
                            $sql = "SELECT 1 FROM FLAT_INSPECTIONS WHERE INSPECTION_ID=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $insp_id);
                            $stmt->execute();
                            $result = $stmt->get_result()->fetch_assoc();

                            $stmt->close();

                            if (is_null($result)) {
                                $sql = "INSERT INTO FLAT_INSPECTIONS(STAFF_NUMBER, DATE_OF_INSPECTION, FLAT_ID, INSPECTION_RESULTS, ADDITIONAL_COMMENTS) VALUES(?, ?, ?, ?, ?);";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("isiss", $staff_num, $doi, $flat_id, $insp_res, $add_comm);
                            } else {
                                $sql = "UPDATE FLAT_INSPECTIONS SET STAFF_NUMBER=?, DATE_OF_INSPECTION=?, FLAT_ID=?, INSPECTION_RESULTS=?, ADDITIONAL_COMMENTS=? WHERE INSPECTION_ID=?;";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("isissi", $staff_num, $doi, $flat_id, $insp_res, $add_comm, $insp_id);
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

                    $sql = "SELECT * FROM FLAT_INSPECTIONS";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $results = $stmt->get_result();
                    while ($result = $results->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>" . $result["INSPECTION_ID"] . "</td>";
                        echo "<td>" . $result["STAFF_NUMBER"] . "</td>";
                        echo "<td>" . $result["DATE_OF_INSPECTION"] . "</td>";
                        echo "<td>" . $result["FLAT_ID"] . "</td>";
                        echo "<td>" . $result["INSPECTION_RESULTS"] . "</td>";
                        echo "<td>" . $result["ADDITIONAL_COMMENTS"] . "</td>";

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
                            Add/Edit Flat Inspections
                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <form class="container d-flex justify-content-center p-2 col-12" method="post"
                          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-row col-12 rounded p-2">
                            <?php if (!empty($msg)) echo $msg; ?>
                            <div class="form-floating p-1">
                                <input type="number" class="form-control" name="insp_id" id="floatingTextarea"></input>
                                <label for="floatingTextarea">ID</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="staff_num" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Staff Number</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="doi" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Date of Inspection</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="flat_id" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Flat ID</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="insp_res" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Inspection ID</label>
                            </div>
                            <div class="form-floating p-1">
                                <input type="text" class="form-control" name="add_comm" id="floatingTextarea"></input>
                                <label for="floatingTextarea">Additional Comments</label>
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
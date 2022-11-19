<!doctype html>
<html lang="en">

<head>
    <?php
    $title = 'View Flats';
    include('headers.php');
    ?>
    <meta name="title" content="Home">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
</head>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($_POST['additional-comments'])){
        $comments = null;
    } else{
        $comments = trim($_POST['additional-comments']);
    }

    if (!empty($_POST['flat_id']) && !empty($_POST['pass_fail_radio'])) {

        $username = $_SESSION['username'];
        $flat_id = intval($_POST['flat_id']);
        $inspection_result = trim($_POST['pass_fail_radio']);

        // create connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

        // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check to see if that flat exists
        $sql = "SELECT 1 FROM STUDENT_FLATS WHERE FLAT_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $flat_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!is_null($result)){
            $stmt->close();
            $conn->close();

            $date = date("Y-m-d");

            // create connection
            $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

            // check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO FLAT_INSPECTIONS(STAFF_NUMBER, DATE_OF_INSPECTION, FLAT_ID, INSPECTION_RESULTS, ADDITIONAL_COMMENTS) VALUES(?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("dsdss", $_SESSION['staff_number'], $date, $flat_id, $inspection_result, $comments);

            if(!$stmt->execute()){
                echo $conn->error;

                $msg = "<p class=\"text-danger\">Error, please try again!</p>";
                $stmt->close();
                $conn->close();



            } else{
                $id=mysqli_insert_id($conn);
                echo $id;
                $stmt->close();
                $conn->close();

                header("Location: https://residentialservices.gehlj.myweb.cs.uwindsor.ca/content/view_inspections.php?id=" . $id);
                die();
            }

        } else{
            $msg = "<p class=\"text-danger\">Flat doesn't exist!</p>";
            $stmt->close();
            $conn->close();
        }
    } else{
        $msg = "<p class=\"text-danger\">Please Enter Flat ID and Inspection Results!</p>";
    }
}

?>

<body class="vh-100">
<?php include('cleanernav.php'); ?>
<div class="yellow_bg container-fluid yellow_bg h-100">
    <div class="p-5"></div>
    <div class="pt-3 row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 blue_bg container-fluid vh-75 rounded-3">
            <div class="row justify-content-center">
                <div class="container-fluid ps-5 pe-5 m-3 w-auto">
                    <div class="text-white text-center fs-2">
                        Add Inspection
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <form class="container d-flex justify-content-center p-3 col-12" method="post">
                    <div class="col-12 rounded p-3">
                        <?php if (!empty($msg)) echo $msg; ?>
                        <div class="form-floating mb-3">
                            <input type="number" step="1" min="1" class="form-control" id="floatingInput" name="flat_id" required>
                            <label for="floatingInput">Flat ID</label>
                        </div>
                        <div class="text-white container-fluid p-0 m-0">
                            <div class="ms-auto">
                                <input class="form-check-input" type="radio" value="Pass" name="pass_fail_radio" id="pass_radio" required>
                                <label class="form-check-label" for="pass_radio">
                                    Pass
                                </label>
                            </div>
                            <div class="ms-auto">
                                <input class="form-check-input" type="radio" value="Fail" name="pass_fail_radio" id="fail_radio" required>
                                <label class="form-check-label" for="fail_radio">
                                    Fail
                                </label>
                            </div>
                        </div>
                        <br/>
                        <div class="form-floating">
                            <textarea class="form-control" name="additional-comments" id="floatingTextarea" style="height: 200px"></textarea>
                            <label for="floatingTextarea">Additional Comments</label>
                        </div>
                        <br/>
                        <div id="button_div">
                            <button type="submit" class="btn btn-primary float-end" id="submit_button" name="submit_button">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
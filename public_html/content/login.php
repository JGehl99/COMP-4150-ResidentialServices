<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = 'Login';
    include('headers.php');
    ?>
    <meta name="title" content="Login">
    <meta name="language" content="English">
</head>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // If they aren't empty
    if (!empty($_POST['username']) && !empty($_POST['password'])) {

        // Get username and password
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // create connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

        // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check to see if username already exists in db
        $sql = "SELECT username, password, position, staff_number FROM HOSTEL_STAFF WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $conn->close();

        // If username empty or password doesn't match, display error
        // Else set session variable to denote being logged in, redirect to main page
        if (empty($result['username'])) {
            // If empty, check if username exists in student

            // create connection
            $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

            // check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check to see if username already exists in db
            $sql = "SELECT username, password FROM STUDENT WHERE username=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $conn->close();


            if (empty($result['username'])) {
                $msg = "<p class=\"text-danger mb-5\">Username or password is incorrect!</p>";
            } else{
                if (password_verify($password, $result['password'])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $result['username'];
                    $_SESSION['account_type'] = "Student";
                    echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
                    exit();
                } else {
                    $msg = "<p class=\"text-danger mb-5\">Username or password is incorrect!</p>";
                }
            }

        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $result['username'];
                $_SESSION['account_type'] = $result['position'];
                $_SESSION['staff_number'] = $result['staff_number'];
                echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
                exit();
            } else {
                $msg = "<p class=\"text-danger mb-5\">Username or password is incorrect!</p>";
            }
        }
    }
}
?>

<body class="page-background">
<div class="yellow_bg container-fluid yellow_bg vh-100">
    <div class="p-2"></div>
    <div class="pt-3 row justify-content-center">
        <div class="col-10 container-fluid rounded-3">
            <div class="row justify-content-center">
                <div class="card background w-auto text-black rounded-5 shadow blue_bg">
                    <div class="card-body p-5 text-center">
                        <form class="mb-md-5 mt-md-4 pb-2" method="post"
                              action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                            <h2 class="fs-2 mb-2 text-uppercase text-white">Login</h2>
                            <p class="text-light mb-5">Please enter your login and password!</p>
                            <?php if (!empty($msg)) echo $msg ?>

                            <div class="form-outline form-white mb-4">
                                <input type="text" id="username" name="username" class="form-control form-control-lg"/>
                                <label class="form-label text-light" for="username">Username</label>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <input type="password" id="password" name="password"
                                       class="form-control form-control-lg"/>
                                <label class="form-label text-light" for="password">Password</label>
                            </div>
                            <button class="btn btn-primary btn-lg px-5 shadow" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
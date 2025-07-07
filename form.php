<?php
require "env.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    // use envfile\DotEnv;

    (new envfile\DotEnv(__DIR__ . '\conn.env'))->load();
    $server = getenv("server");
    $username = getenv("username");
    $password = getenv("password");
    $db = getenv('db');
    $conn = mysqli_connect($server,$username,$password, $db);
    if ($conn->connect_error) {
        echo "connection error";
        exit();
    }
} catch (mysqli_sql_exception $e) {
    die("error:" . $e->getMessage());
}
if (isset($_POST['submit'])) {
    try {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $gender = $_POST['gender'];
        $state = $_POST['state'];
        if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
            echo 'Invalid name';
            exit();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email';
            exit();
        } else if (empty($city)) {
            echo 'enter city';
            exit();
        } else {
            $stmt = $conn->prepare('select email from tab1 where email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($res->num_rows > 0) {
                echo "email already exists";
                exit();
            }
            $stmt = $conn->prepare("insert into tab1 (name,email,city,gender,state) values(?,?,?,?,?)");
            $stmt->bind_param('sssss', $name, $email, $city, $gender, $state);
            if (!$stmt->execute()) {
                echo "error while inserting data";
            }
        }
    } catch (mysqli_sql_exception $e) {
        die("error:" . $e->getMessage());
    }
}
if (isset($_GET['req']) && $_GET['req'] == 'sel') {
    try {
        $stmt = $conn->prepare('select * from tab1');
        if ($stmt) {
            if (!$stmt->execute()) {
                echo "error while selecting data";
                exit();
            } else {
                $result = $stmt->get_result(); // get the mysqli result
                $row = [];
                while ($user = $result->fetch_assoc()) {
                    $row[] = $user;
                }
                header("Content-Type:application/json");
                echo json_encode($row);
            }
        } else {
            echo "error while preparing statement";
        }
    } catch (mysqli_sql_exception $e) {
        die("error:" . $e->getMessage());
    }
}
if (isset($_GET['req']) && $_GET['req'] == 'dlt') {
    try {
        $dlt_id = $_POST['id'];
        $stmt = $conn->prepare('delete from tab1 where id = ?');
        $stmt->bind_param('i', $dlt_id);
        if ($stmt) {
            if (!$stmt->execute()) {
                echo "error while deleting data";
                exit();
            } else {
                echo "Delete sucess";
            }
        } else {
            echo "error while preparing statement";
        }
    } catch (mysqli_sql_exception $e) {
        die("error:" . $e->getMessage());
    }
}
if (isset($_GET['req']) && $_GET['req'] == 'upd') {
    try {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $gender = $_POST['gender'];
        $state = $_POST['state'];
        if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
            echo 'Invalid name';
            exit();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email';
            exit();
        } else if (empty($city)) {
            echo 'enter city';
            exit();
        } else {
            $stmt = $conn->prepare('select email from tab1 where id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $existing_email = $row['email'];

            if ($email !== $existing_email) {
                $stmt = $conn->prepare('select id from tab1 where email = ?');
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res->num_rows > 0) {
                    echo "email already exists";
                    exit();
                }
            }
            $stmt = $conn->prepare('UPDATE tab1 SET name= ? , email=?,city = ?,gender = ? ,state=? WHERE id=?');
            $stmt->bind_param('sssssi', $name, $email, $city, $gender, $state, $id);
            if (!$stmt->execute()) {
                echo "error while updating  data";
                exit();
            } else {
                echo "update success";
            }
        }
    } catch (mysqli_sql_exception $e) {
        die("error:" . $e->getMessage());
    }
}

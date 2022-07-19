<?php
session_start();


if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../components/db_connect.php';

if ($_POST) {
    $rental_date = $_POST['rental_date'];
    $car_id = $_POST['id'];
    $user_id = $_SESSION['user'];
    $res = mysqli_query($connect, "SELECT * FROM rental WHERE rental_date = '$rental_date' && fk_car_id = $car_id");
    if (mysqli_num_rows($res) >= 1) {
        $class = "danger";
        $message = "Error. The car is already reserved for the selected date.";
    } elseif (strtotime($rental_date) < strtotime(date("ymd"))) {
        $class ="danger";
        $message = "Error. You are trying to rent a car in the past.";
    } else {
    $sql = "INSERT INTO rental (rental_date, fk_car_id, fk_user_id) VALUES ('$rental_date', $car_id, $user_id)";
    if (mysqli_query($connect, $sql) === true) {
        $class = "success";
        $message = "You successfully registered for renting this car on " . $rental_date;
    } else {
        $class = "danger";
        $message = "Error while creating record. Try again: <br>" . $connect->error;
    }
}
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update</title>
    <?php require_once '../../components/boot.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Create request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <a href='../../home.php'><button class="btn btn-primary" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>
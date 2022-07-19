<?php 
session_start();
require_once "components/db_connect.php";
require_once "components/boot.php";
// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// select logged-in users details - procedural style
$res = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);

$sql = "SELECT * from cars";
$result = mysqli_query($connect, $sql);
$body = "<div class='row row-cols-1 row-cols-md-5 g-4'>";

if(mysqli_num_rows($result) > 0){
while($row1 = mysqli_fetch_assoc($result)){
    $body .=    "<div class='col'>
                <div class='card'>
                <img src='pictures/" . $row1['picture'] . "' class='card-img-top' alt='Car' width='200' height='300'>
                <div class='card-body'>
                <h5 class='card-title'>" . $row1['brand'] . " " . $row1['model'] . "</h5>       
                <a href='rentals/create.php?id=" . $row1['id'] . "'><button class='btn btn-primary' type='button'>Rent</button></a>
                </div></div></div>";
}
}
$body .= "</div>";
mysqli_close($connect)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Car Rental</title>
</head>

<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Welcome, <?php echo $row['fname'] . " " . $row['lname'] ?> </a>
    </div>
        <a href="update.php?id= <?php echo $row['id']?>"><button class='btn btn-success navbar-btn' type='button'>Update your profile</button></a>
        <a href="logout.php?logout"><button class='btn btn-danger navbar-btn' type='button'>Logout</button></a>
  </div>
</nav>

           <?php echo $body?>

</body>

</html>
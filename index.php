<?php
include("config.php");
?>

<!---------------------------------------------------->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div class="container">
            <h1>Registration:</h1>
            <label for="uname"><b>Username</b></label>
            <input type="text" name="uname" required>
            <label for="psw"><b>Password</b></label>
            <input type="password" name="psw" required>
            <button type="submit">Register</button>
            <a href="./login.php">Login</a>
        </div>
    </form>
</body>

</html>

<!---------------------------------------------------->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = filter_input(INPUT_POST, "uname", FILTER_SANITIZE_SPECIAL_CHARS);
    $psw = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_SPECIAL_CHARS);
    $hash = password_hash($psw, PASSWORD_DEFAULT);
    $psw = $hash;
    echo ($uname . " " . $psw . "<br>");
    $sql = "insert into credentials (uname, psw) values ('$uname', '$psw')";
    if (mysqli_query($conn, $sql)) {
        header("location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>
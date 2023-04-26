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
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <title>🖤 Moje Rande 🧡</title>
</head>
<body>
<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <div class="container">
        <label for="uname"><b>Username</b></label>
        <input type="text" name="uname" required>
        <label for="psw"><b>Password</b></label>
        <input type="password" name="psw" required>
        <button type="submit">Login</button>
    </div>
</form>
</body>
</html>

<!---------------------------------------------------->

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $uname = filter_input(INPUT_POST, "uname", FILTER_SANITIZE_SPECIAL_CHARS);
        $psw = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_SPECIAL_CHARS);

        $hash = password_hash($psw, PASSWORD_DEFAULT);
        $sql = "select *from users where username = '$username' and password = '$password'";  
        mysqli_query($conn, $sql);
        
    }

    mysqli_close($conn);

?>
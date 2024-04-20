<?php
include_once('utils.php');
if (strpos($_SERVER['HTTP_REFERER'], 'admin.php') === false) {
    $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
}
if ($_SESSION['ID'] != 1) {
    header('Location: ./');
    exit();
}

if (isset($_POST['form_name'])) {
    $conn = mysqli_connect($_SESSION["conn_params"]['host'], $_SESSION["conn_params"]['user'], $_SESSION["conn_params"]['password'], 'mojerandedb', $_SESSION["conn_params"]['port']);
    try {
        switch ($_POST['form_name']) {
            case 'delete_database':
                mysqli_query($conn, "DROP DATABASE IF EXISTS mojerandedb");
                mysqli_close($conn);
                unset($_SESSION['conn_params']);
                header('Location: ./');
                exit();
            case 'delete_connection':
                unset($_SESSION['conn_params']);
                unlink('connection_params.txt');
                $_SESSION['delete_conn_params'] = true;
                header('Location: ./');
                exit();
            case 'update_database':
                try {
                    createDatabase($conn);
                    $success = 'Databáze byla úspěšně aktualizována!';
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                break;
            case 'delete_user':
                try{
                    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
                    $sql = "SELECT profilePicture FROM credentials WHERE ID = '$userId'";
                    $profilePicture = mysqli_query($conn, $sql);
                    $profilePicture = mysqli_fetch_array($profilePicture)["profilePicture"];
                    $sql = "DELETE FROM credentials WHERE ID = '$userId'";
                    mysqli_query($conn, $sql);
                    if ($profilePicture != 'default.png') {
                        unlink('./protected/profilePictures/' . $profilePicture);
                    }
                    $success = 'Uživatel byl úspěšně smazán!';
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                break;
            case 'delete_pfp':
                try {
                    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
                    $sql = "SELECT profilePicture FROM credentials WHERE ID = '$userId'";
                    $profilePicture = mysqli_query($conn, $sql);
                    $profilePicture = mysqli_fetch_array($profilePicture)["profilePicture"];
                    $sql = "UPDATE credentials SET profilePicture = 'default.png' WHERE ID = '$userId'";
                    mysqli_query($conn, $sql);
                    if ($profilePicture != 'default.png') {
                        unlink('./protected/profilePictures/' . $profilePicture);
                    }
                    $success = 'Profilový obrázek byl úspěšně smazán!';
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                break;
            default:
                break;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./protected/img/favicon.ico">
</head>
<body>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger text-center" role="alert" id="alert">
        MySQL Error: <?= $error ?>
    </div>
    <script>
        setTimeout(function () {
            document.getElementById('alert').style.display = 'none';
        }, 2000);
    </script>
<?php endif; ?>

<?php if (isset($success)) : ?>
    <div class="alert alert-success text-center" role="alert" id="alert">
        <?= $success ?>
    </div>
    <script>
        setTimeout(function () {
            document.getElementById('alert').style.display = 'none';
        }, 2000);
    </script>
<?php endif; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Admin panel</h1>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="post" onsubmit="return confirmDeleteDatabase();">
                <input type="hidden" name="form_name" value="delete_database">
                <button type="submit" class="btn btn-danger w-100 mb-3">Smazat databázi</button>
            </form>
            <form method="post" onsubmit="return confirmDeleteConnection();">
                <input type="hidden" name="form_name" value="delete_connection">
                <button type="submit" class="btn btn-danger w-100 mb-3">Smazat připojení</button>
            </form>
            <form method="post" onsubmit="return confirmUpdateDatabase();">
                <input type="hidden" name="form_name" value="update_database">
                <button type="submit" class="btn btn-info w-100">Aktualizovat databázi</button>
            </form>
            <a href="<?php echo $_SESSION['referer'] ?? './'; ?>" class="btn btn-primary w-100 mt-3">Zpátky</a>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Moderování</h1>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <?php
        $sql = "SELECT * FROM credentials WHERE ID != 1";
        $users = mysqli_query($conn, $sql);
        if (mysqli_num_rows($users) > 0) {
            while ($row = mysqli_fetch_assoc($users)) {
                echo '<div class="col-md-6">';
                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<div class="row">';
                echo '<div class="col-md-8">';
                echo '<h5 class="card-title">' . $row['firstName']. ' ' . $row['lastName'] .'</h5>';
                echo '<p class="card-text">Email: ' . $row['email'] . '</p>';
                //Buttons to remove the user or pfp
                // Make it work by post request
                echo '<div class="d-flex flex-row justify-content-between">';
                echo '<form method="post">';
                echo '<input type="hidden" name="form_name" value="delete_user">';
                echo '<input type="hidden" name="user_id" value="' . $row['ID'] . '">';
                echo '<button type="submit" class="btn btn-danger mr-2">Smazat uživatele</button>'; // Added mr-2 class for right margin
                echo '</form>';
                echo '<form method="post">';
                echo '<input type="hidden" name="form_name" value="delete_pfp">';
                echo '<input type="hidden" name="user_id" value="' . $row['ID'] . '">';
                if ($row['profilePicture'] == 'default.png') {
                    echo '<button type="submit" class="btn btn-info" disabled>Smazat profilový obrázek</button>';
                } else {
                    echo '<button type="submit" class="btn btn-info">Smazat profilový obrázek</button>';
                }
                echo '</form>';
                echo '</div>';
                echo '</div>';


                echo '<div class="col-md-4 d-flex flex-row-reverse">';
                // Add border to the profile picture
                echo '<img src="./protected/profilePictures/' . $row['profilePicture'] . '" class="img-fluid rounded-circle border border-secondary" alt="Profile Picture" style="width: 100px; height: 100px;">';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-center">Žádní uživatelé</p>';
        }
        ?>
    </div>
</div>

<script>
    function confirmDeleteDatabase() {
        return confirm("Jste si jistí, že chcete smazat databázi?");
    }

    function confirmDeleteConnection() {
        return confirm("Jste si jistí, že chcete vymazat připojení k databázi?");
    }

    function confirmUpdateDatabase() {
        return confirm("Jste si jistí, že chcete aktualizovat databázi?");
    }
</script>

</body>
</html>

<?php
$sql = "SELECT coins FROM credentials WHERE ID = '$Id'";
$result = mysqli_query($conn, $sql);
$coins = mysqli_fetch_array($result)["coins"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="icon" type="image/x-icon" href="./protected/img/favicon.ico">
    <title>🖤 <?php switch ($pageName) {
            default:
                echo 'Moje Rande';
                break;
            case 'chat.php':
                echo 'Chat';
                break;
        } ?>
        🧡</title>
</head>

<body class="d-flex flex-column min-vh-100" id="body">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark nav-underline">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php"><img src="./protected/img/logo.png" width="200px"
                                                        height="50px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo $pageName === 'home.php' ? 'active" style="color: #ff9900;"' : '"'; ?> href="
                       ./home.php">Domu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $pageName === 'date.php' ? 'active" style="color: #ff9900;"' : '"'; ?> href="
                       ./date.php">Chci rande!</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $pageName === 'help.php' ? 'active" style="color: #ff9900;"' : '"'; ?> href="
                       ./help.php">Podpora</a>
                </li>
                <li>
                    <a class="nav-link <?php echo $pageName === 'chat.php' ? 'active" style="color: #ff9900;"' : '"'; ?> href="
                       ./chat.php">Chat</a>
                </li>
            </ul>
            <ul class="navbar-nav mt-2 mb-2 mb-lg-0">

                <li class="nav-item">
                    <button id="switch" class="btn nav-link" onclick="cycleThemes()"></button>
                <li class="nav-item">
                    <a class="nav-link" href="./shop.php">
                        <?php echo $coins; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-coin" viewBox="0 0 16 16">
                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z"/>
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/>
                        </svg>
                    </a>
                </li>
                <?php if ($Id == 1) { ?>
                    <li class="nav-item me-2">
                        <a class="nav-link" style="color: #ff9900;" href="./admin.php">Admin panel</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item me-2">
                        <a class="nav-link" style="color: #ff9900;"
                           href="./settings.php"><?php echo $firstName . " " . $lastName ?></a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" style="color: red;" href="./logout.php">Odhlásit se</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
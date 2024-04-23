<?php
include_once('utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$Id = $_SESSION['ID'];
if (isset($_POST['cancel'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM `dates` WHERE `ID` = ?");
        $stmt->bind_param("i", $_POST['dateID']);
        $stmt->execute();
        $stmt->close();
        $success = "Rande bylo úspěšně zrušeno.";
    } catch (Exception $e) {
        $error = $e;
    }
}
if (isset($_POST['send_message'])) {
    try {
    $stmt = "SELECT * FROM `dates` WHERE `ID` = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $_POST['dateID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['senderId'] == $_SESSION['ID']) {
        $dateId = $row['recipientId'];
    } else {
        $dateId = $row['senderId'];
    }
    //Check if chat room already exists
    $stmt = "SELECT * FROM `chat_rooms` WHERE `user1_id` = ? AND `user2_id` = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("ii", $_SESSION['ID'], $dateId);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) == 0) {
        $stmt = "SELECT * FROM `chat_rooms` WHERE `user1_id` = ? AND `user2_id` = ?";
        $stmt = $conn->prepare($stmt);
        $stmt->bind_param("ii", $dateId, $_SESSION['ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) == 0) {
            // Create chat room
            $stmt = "INSERT INTO `chat_rooms` (`user1_id`, `user2_id`) VALUES (?,?)";
            $stmt = $conn->prepare($stmt);
            $stmt->bind_param("ii", $_SESSION['ID'], $dateId);
            $stmt->execute();
        } else {
            $reverse = true;
        }
    }
    //Get chat room id
    if (isset($reverse) && $reverse) {
        $stmt = "SELECT ID FROM `chat_rooms` WHERE `user2_id` = ? AND `user1_id` = ?";
    } else {
        $stmt = "SELECT ID FROM `chat_rooms` WHERE `user1_id` = ? AND `user2_id` = ?";
    }
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("ii", $_SESSION['ID'], $dateId);
    $stmt->execute();
    $chatRoomId = $stmt->get_result()->fetch_assoc()['ID'];
    //Reroute to chat
    header("Location: chat.php?chatRoomId=" . $chatRoomId);
    } catch (Exception $e) {
        $error = $e;
    }
}
if (isset($_POST['submit'])) {
    try{
    $stmt = "UPDATE `dates` SET `confirmed` = '1' WHERE `dates`.`ID` = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $_POST['dateID']);
    $stmt->execute();
    $success = "Rande bylo úspěšně potvrzeno.";
    } catch (Exception $e) {
        $error = $e;
    }
}

$sql = "SELECT * FROM `dates` WHERE `senderId` = '$Id' OR `recipientId` = '$Id'";
$result = mysqli_query($conn, $sql);

$dates = array();
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row;
}
$pageName = "home.php";
include ('./templates/head_and_navbar.php');
?>
<section id="dates" class="p-5">
    <div class="container">
        <div class="row g-4">
            <?php if (empty($dates)): ?>
                <h2 class="text-center">Nemáte žádné domluvené schůzky.</h2>
            <?php else: ?>
                <h2 class="text-center">Domluvené schůzky:</h2>
                <br>
                <?php foreach ($dates as $date): ?>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM `credentials` WHERE `ID` = ?");
                    if ($Id != $date['senderId']) {
                        $stmt->bind_param("i", $date['senderId']);
                    } else {
                        $stmt->bind_param("i", $date['recipientId']);
                    }
                    $stmt->execute();
                    $row = $stmt->get_result()->fetch_assoc();
                    $firstNameDate = $row['firstName'];
                    $lastNameDate = $row['lastName'];
                    $profilePictureDate = "./protected/profilePictures/" . $row['profilePicture'];
                    ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-dark"
                             style="background-color: <?php echo $date['confirmed'] ? '#45c700' : '#ff9900'; ?>;">
                            <div class="card-body text-center">
                                <div id="card-top">
                                    <img src="./protected/profilePictures/<?= $row['profilePicture'] ?>" class="rounded-circle" id="image" alt="">
                                    <h3 class="card-title"><span style="font-weight: 600;"><?= $firstNameDate ?></span><br><span style="font-size: large;"><?= $lastNameDate ?></span></h3>
                                </div>
                                <br>
                                <h6 class="card-subtitle mb-2"><span class="d-flex">Místo: <a class="ms-auto text-primary" target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?=str_replace(" ", "+", $date['place'])?>"><?= $date['place']?></a></span></h6>
                                <h6 class="card-subtitle mb-2"><span class="d-flex">Datum a čas: <span class="ms-auto"><?= date("d.m.Y", strtotime($date['dateInvitation'])) ?> <?= date("h:i", strtotime($date['dateInvitation'])) ?></span></span></h6>
                                <?php if($date['message'] != ""): ?>
                                    <h6 class="card-subtitle mb-2"><span class="d-flex">Zpráva: <span class="ms-auto"><?= $date['message']?></span></span></h6>
                                <?php endif; ?>
                                <form method="post">
                                    <input type="hidden" name="dateID" value="<?= $date['ID'] ?>">
                                    <button class="btn btn-danger mt-3" name="cancel">Zrušit rande</button>
                                    <button class="btn btn-info mt-3" name="send_message">Napsat zprávu</button>
                                    <?php if ($date['senderId'] != $Id): ?>
                                        <button class="btn btn-success mt-3" name="submit">Potvrdit rande</button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
include('./templates/footer.php');
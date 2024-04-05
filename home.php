<?php
include('utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$Id = $_SESSION['ID'];

$sql = "SELECT * FROM `dates` WHERE `senderId` = '$Id' OR `recipientId` = '$Id'";
$result = mysqli_query($conn, $sql);

$dates = array();
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row;
}
$pageName = "home.php";
include ('./templates/head_and_navbar.php');
if (isset($_POST['cancel'])) {
    $sql = "DELETE FROM `dates` WHERE `dates`.`ID` = '" . $_POST['dateID'] . "'";
    mysqli_query($conn, $sql);
?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Rande bylo úspěšně zrušeno!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<script>
    setTimeout(function () {
        window.location.href = "./home.php";
    }, 2500);
</script>
<?php }
if (isset($_POST['send_message'])) {
    $dateId = "";
    $sql = "SELECT * FROM `dates` WHERE `ID` = '" . $_POST['dateID'] . "'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['senderId'] == $_SESSION['ID']) {
            $dateId = $row['recipientId'];
        } else {
            $dateId = $row['senderId'];
        }
    }
    $date_id = 0;
    // Get date id
    $sql = "SELECT ID FROM `credentials` WHERE `ID` = '" . $dateId . "'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $date_id = $row['ID'];
    }
    //Check if chat room already exists
    $sql = "SELECT * FROM `chat_rooms` WHERE `user1_id` = '" . $_SESSION['ID'] . "' AND `user2_id` = '" . $date_id . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        $sql = "SELECT * FROM `chat_rooms` WHERE `user1_id` = '" . $date_id . "' AND `user2_id` = '" . $_SESSION['ID'] . "'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            // Create chat room
            $sql = "INSERT INTO `chat_rooms` (`user1_id`, `user2_id`) VALUES ('" . $_SESSION['ID'] . "', '" . $date_id . "')";
            mysqli_query($conn, $sql);
        }
    }
    //Get chat room id
    $chatRoomId = 0;
    $sql = "SELECT ID FROM `chat_rooms` WHERE `user1_id` = '" . $_SESSION['ID'] . "' AND `user2_id` = '" . $date_id . "'";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $chatRoomId = $row['ID'];
    }
    //Reroute to chat
    //TODO: Make reroute to the specific chat right away
    header("Location: chat.php?chatRoomId=" . $chatRoomId);
}
if (isset($_POST['submit'])) {
        $sql = "UPDATE `dates` SET `confirmed` = '1' WHERE `dates`.`ID` = '" . $_POST['dateID'] . "'";
        mysqli_query($conn, $sql);
?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Rande bylo úspěšně potvrzeno!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<script>
    setTimeout(function () {
        window.location.href = "./home.php";
    }, 2500);
</script>
<?php } ?>
    <section id="dates" class="p-5">
        <div class="container">
                <?php
                    if (empty($dates)) {
                        echo "<h2 class='text-center'>Nemáte žádné domluvené schůzky.</h2>";
                    } else {
                ?>
                <h2 class="text-center">Domluvené schůzky:</h2>
                <br>
                <div class="row g-4">
                    <?php
                    for ($i = 0; $i < sizeof($dates); $i++) {
                        if ($Id != $dates[$i]['senderId']) {
                            $sql = "SELECT * FROM `credentials` WHERE `ID` = '" . $dates[$i]['senderId'] . "'";
                        }
                        if ($Id != $dates[$i]['recipientId']) {
                            $sql = "SELECT * FROM `credentials` WHERE `ID` = '" . $dates[$i]['recipientId'] . "'";
                        }
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $firstNameDB = $row['firstName'];
                        $lastNameDB = $row['lastName'];
                        $profilePictureDB = "./protected/profilePictures/" . $row['profilePicture'];
                    ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card"
                                 style="background-color: <?php echo $dates[$i]['confirmed'] ? '#00cc00' : '#ffff00'; ?>; color: black;">
                                <div class="card-body text-center">
                                    <div id="card-top">
                                        <img src="<?php echo $profilePictureDB; ?>" class="rounded-circle" id="image"
                                             alt="">
                                        <h3 class="card-title"><span
                                                    style="font-weight: 600;"><?php echo $firstNameDB; ?></span><br><span
                                                    style="font-size: large;"><?php echo $lastNameDB; ?></span></h3>
                                    </div>
                                    <br>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Místo: <?php echo $dates[$i]['place']; ?></h6>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Datum: <?php echo date("d.m.Y", strtotime($dates[$i]['dateInvitation'])); ?></h6>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Čas: <?php echo date("h:i", strtotime($dates[$i]['dateInvitation'])); ?></h6>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Zpráva: <?php echo $dates[$i]['message']; ?></h6>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="dateID" value="<?php echo $dates[$i]['ID']; ?>">
                                        <?php if ($dates[$i]['senderId'] == $_SESSION["ID"] || $dates[$i]['confirmed']) { ?>
                                            <button href="#" class="btn btn-danger mt-3" name="cancel">Zrušit rande
                                            </button>
                                            <button href="#" class="btn btn-info mt-3" name="send_message">Napsat zprávu
                                            </button>
                                        <?php } else if ($dates[$i]['senderId'] != $_SESSION["email"]) { ?>
                                            <button href="#" class="btn btn-success mr-2 mt-3" name="submit">Potvrdit
                                            </button>
                                            <button href="#" class="btn btn-danger mt-3" name="cancel">Odmítnout
                                            </button>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php
include('./templates/footer.php');
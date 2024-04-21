<?php
include_once('utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$sexuality = $_SESSION['sexuality'];
$Id = $_SESSION['ID'];
$dateSent = false;

$sql = "SELECT * FROM credentials";
$result = mysqli_query($conn, $sql);
$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

shuffle($users);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['chat'])) {
        try {
            $dateId = $_POST['recipientId'];
            //Check if chat room already exists
            $stmt = "SELECT * FROM `chat_rooms` WHERE `user1_id` = ? AND `user2_id` = ?";
            $stmt = $conn->prepare($stmt);
            $stmt->bind_param("ii", $_SESSION['ID'], $dateId);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) == 0) {
                echo "not found, trying reverse";
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
            if (isset($chatRoomId)) {
                header("Location: chat.php?chatRoomId=" . $chatRoomId);
            } else {
                $error = "Něco se pokazilo.". " " . $dateId . " " . $_SESSION['ID'];
                //testing
            }
        } catch (Exception $e) {
            $error = $e;
        }
    }
    foreach ($users as $i => $user) {
        if (isset($_POST["send-date-$i"])) {
            try {
                $senderId = $_SESSION['ID'];
                $date = mysqli_real_escape_string($conn, $_POST['sender-date']);
                $time = mysqli_real_escape_string($conn, $_POST['sender-time']);
                $message = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['sender-message']));
                $place = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['sender-place']));
                $recipientId = mysqli_real_escape_string($conn, $_POST['recipientId']);

                $datetime = $date . ' ' . $time;

                $stmt = "INSERT INTO dates (senderId, recipientId, dateInvitation, message, place)
                    VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $stmt);
                $stmt->bind_param("iisss", $senderId, $recipientId, $datetime, $message, $place);
                $stmt->execute();
                $stmt->close();
                $success = "Žádost o rande byla úspěšně odeslána.";
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            break;
        }
    }
}

$pageName = 'date.php';
include('./templates/head_and_navbar.php');
?>
<section id="dates" class="p-5">
    <div class="container-fluid mb-0 pb-0">
        <h2 class="text-center">Nabídka</h2>
        <br>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-4">
            <?php foreach ($users as $i => $user) {
                if ($user['email'] != "admin@admin.com" && $user['email'] != $_SESSION['email']) {
                    $firstNameDB = $user['firstName'];
                    $lastNameDB = $user['lastName'];
                    $aboutMeDB = $user['aboutMe'];
                    $sexualityDB = $user['sexuality'];
                    $gender = $user['gender'];
                    $birthDateDB = $user['birthDate'];
                    $now = date("Y-m-d");
                    $diff = date_diff(date_create($birthDateDB), date_create($now));
                    $profilePictureDB = "./protected/profilePictures/" . $user['profilePicture'];
                    echo '<div class="col">';
                    echo '<div class="card bg-secondary text-white">';
                    echo '<img src="' . $profilePictureDB . '" class="card-img-top rounded text-center" alt="User Image" style="width: 100%; height: 200px;">';
                    echo '<div class="card-body">';
                    echo '<h3 class="card-title"><span style="font-weight: 600;">' . $firstNameDB . '</span></h3>';
                    echo '<p class="card-title" style="font-size: large;">' . $lastNameDB . '</p>';
                    echo '<p class="card-subtitle mb-2 d-flex"><b>Věk: </b><span class="ms-auto">' . $diff->format('%y') . '</span></p>';
                    echo '<p class="card-subtitle mb-2 d-flex"><b>Pohlaví: </b><span class="ms-auto">' . gender($gender) . '</span></p>';
                    echo '<p class="card-subtitle mb-2 d-flex"><b>Sexualita: </b><span class="ms-auto">' . sexuality($sexualityDB) .'</span></p>';
                    if ($aboutMeDB != "") {
                        echo '<h6 class="card-subtitle mb-2"><b>O mně:</b> </h6>';
                        echo '<p class="card-text">' . $aboutMeDB . '</p>';
                    }
                    echo '<div class="row">';
                    echo '<div class="col">';
                    echo '<button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#exampleModal' . $i . '">Požádat o rande</button>';
                    echo '</div>';
                    echo '<div class="col">';
                    echo '<form method="post">';
                    echo '<button name="chat" type="submit" class="btn btn-info w-100">Poslat zprávu</button>';
                    echo '<input type="hidden" name="recipientId" value="' . $user['ID'] . '">';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '<div class="modal fade" id="exampleModal' . $i . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog">';
                    echo '<div class="modal-content" id="cardbg">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="exampleModalLabel">Požádat o rande</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo '<form method="post">';
                    echo '<div class="mb-3">';
                    echo '<label for="sender-name" class="col-form-label">Jméno:</label>';
                    echo '<input type="text" class="form-control" id="sender-name" name="sender-name" value="' . $firstNameDB . ' ' . $lastNameDB . '" disabled>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="sender-date" class="col-form-label">Datum:</label>';
                    echo '<input type="date" class="form-control" id="sender-date" name="sender-date" required min="' . date('Y-m-d') . '">';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="sender-time" class="col-form-label">Čas:</label>';
                    echo '<input type="time" class="form-control" id="sender-time" name="sender-time" required>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="sender-place" class="col-form-label">Místo:</label>';
                    echo '<input type="text" class="form-control" id="sender-place" name="sender-place" required>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="sender-message" class="col-form-label">Zpráva:</label>';
                    echo '<textarea class="form-control" id="sender-message" name="sender-message"></textarea>';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>';
                    echo '<button type="submit" class="btn btn-primary" name="send-date-' . $i . '">Odeslat</button>';
                    echo '</div>';
                    echo '<input type="hidden" name="recipientId" value="' . $user['ID'] . '">';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } ?>
        </div>
    </div>
</section>


<script>
    function checkTimeValidity() {
        const today = new Date();
        const todayDate = today.toISOString().slice(0, 10);
        const selectedDateInput = document.getElementById("sender-date");
        const selectedDate = new Date(selectedDateInput.value);

        const selectedDateFormatted = selectedDate.toISOString().slice(0, 10);

        if (selectedDateFormatted === todayDate) {
            const currentTime = new Date();
            const currentHours = currentTime.getHours();
            const currentMinutes = currentTime.getMinutes();

            const selectedTime = document.getElementById("sender-time").valueAsDate;
            const selectedHours = selectedTime.getHours();
            const selectedMinutes = selectedTime.getMinutes();
            if (selectedHours < currentHours || (selectedHours === currentHours && selectedMinutes < currentMinutes)) {
                alert("Prosím, vyberte platný čas.");
                document.getElementById("sender-time").value = null;
            }
        }
    }

    document.getElementById("sender-time").addEventListener("change", checkTimeValidity);
    document.getElementById("sender-date").addEventListener("change", checkTimeValidity);
</script>
<?php
include('./templates/footer.php');
?>

<?php
function sexuality($sexuality)
{
    switch ($sexuality) {
        case "S":
            return "Heterosexuál";
            break;
        case "G":
            return "Homosexuál";
            break;
        case "L":
            return "Lesba";
            break;
        case "B":
            return "Bisexuál";
            break;
        case "A":
            return "Asexuál";
            break;
        case "D":
            return "Demisexuál";
            break;
        case "P":
            return "Pansexuál";
            break;
        case "Q":
            return "Queer";
            break;
        case "?":
            return "Nejisté";
            break;
        default:
            return null;
            break;
    }
}

function gender($gender)
{
    switch ($gender) {
        case "M":
            return "Muž";
            break;
        case "F":
            return "Žena";
            break;
        case "MtF":
            return "Trans žena";
            break;
        case "FtM":
            return "Trans muž";
            break;
        default:
            return null;
    }
}

function getChatMate(mysqli $conn, string $email, int $user1_id, int $user2_id): ?array
{
    $sql = "SELECT * FROM `credentials` WHERE `ID` IN (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user1_id, $user2_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user1 = null;
    $user2 = null;

    while ($row = $result->fetch_assoc()) {
        if ($row['ID'] == $user1_id) {
            $user1 = $row;
        } elseif ($row['ID'] == $user2_id) {
            $user2 = $row;
        }
    }

    if ($user2['email'] == $email) {
        return $user1;
    } else {
        return $user2;
    }
}


function printMyMessage(string $message, string $time, string $pfp): void
{
    // 12:00 PM | Aug 13
    echo "<div class='media mb-3 text-end'>";
    echo "<img src=" . $pfp . " alt='user' width='50' class='rounded-circle'>";
    echo "<div class='media-body ml-3'>";
    echo "<div class='rounded py-2 px-3 mb-1 mt-1 d-inline-block mw-100' style='overflow-wrap: break-word; background-color: #FF9900;'>";
    echo "<p class='text-small mb-0 text-dark text-start'>" . $message . "</p>";
    echo "</div>";
    echo "<p class='small text-muted'>" . $time . "</p>";
    echo "</div>";
    echo "</div>";
}

/**
 * Prints a message from the receiver. This function is used for the chat.
 *
 * @param string $message Message to be printed.
 * @param string $time Timestamp of the message.
 * @param string $pfp Profile picture of the sender. (URL)
 * @return void
 */
function printReceiverMessage(string $message, string $time, string $pfp): void
{
    echo "<div class='media mb-3'>";
    echo "<img src=" . $pfp . " alt='user' width='50' class='rounded-circle'>";
    echo "<div class='media-body ml-3'>";
    echo "<div class='bg-secondary rounded py-2 px-3 mb-1 mt-1 d-inline-block mw-100' style='overflow-wrap: break-word;'>";
    echo "<p class='text-light mb-0'>" . $message . "</p></div>";
    echo "<p class='small text-muted'>" . $time . "</p>";
    echo "</div>";
    echo "</div>";
}
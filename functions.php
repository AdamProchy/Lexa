<?php
function getChatMate(mysqli $conn, string $email, int $user1_id, int $user2_id)
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


function printMyMessage(string $message, string $time, string $pfp)
{
    // 12:00 PM | Aug 13
    echo "<div class='media mb-3 text-end'>";
    echo "<img src=" . $pfp . " alt='user' width='50' class='rounded-circle'>";
    echo "<div class='media-body ml-3'>";
    echo "<div class='rounded py-2 px-3 mb-1 mt-1 d-inline-block mw-100' style='overflow-wrap: break-word; background-color: #FF9900;'>";
    echo "<p class='text-small mb-0 text-light text-start'>" . $message . "</p>";
    echo "</div>";
    echo "<p class='small text-muted'>" . $time . "</p>";
    echo "</div>";
    echo "</div>";
}

function printReceiverMessage(string $message, string $time, string $pfp)
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
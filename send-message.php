<?php
include('utils.php');

//show errors


session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chatRoomId = $_POST['chatRoomId'];
    $message = $_POST['message'];
    $user1_id = $_POST['user1_id'];
    $user2_id = $_POST['user2_id'];

    $sql = "INSERT INTO `messages` (`sender_id`, `receiver_id`, `message`) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user1_id, $user2_id, $message);
    $stmt->execute();
    $stmt->close();

    //Insert the last_message time into chatroom
    $sql = "UPDATE `chat_rooms` SET `last_message` = NOW() WHERE `ID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $chatRoomId);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    header("Location: chat.php?chatRoomId=" . $chatRoomId);
    exit();
}

<?php
session_start();
include "connection.php";

// uppercase the first letter
function titleCase($string)
{
    return ucwords(strtolower(trim($string)));
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// edit users profile
if ($action === 'edit') {
    // apply title case
    $usersName = titleCase($_POST['usersName']);

    // query to update user details into db
    $stmt = $connect->prepare("UPDATE users SET usersName=?, usersPhone=?, usersEmail=?, usersPassword=?, usersRole=?, usersStatus=? WHERE usersID=?");
    $stmt->bind_param("sssssss", $usersName, $_POST['usersPhone'], $_POST['usersEmail'], $_POST['usersPassword'], $_POST['usersRole'], $_POST['usersStatus'], $_POST['id']);

    // execute query and redirect to user page
    $stmt->execute() ? header("Location: users.php?success=updated") : header("Location: users.php?error=update");
}
?>
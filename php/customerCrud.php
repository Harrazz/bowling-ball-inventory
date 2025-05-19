<?php
session_start();
include "connection.php";

function generateCustomerID($connect)
{
    $sql = "SELECT MAX(CAST(SUBSTRING(custID, 2) AS UNSIGNED)) AS maxID FROM customer WHERE custID LIKE 'C%'";
    $result = $connect->query($sql);
    $newNumber = $result && $result->num_rows > 0 ? $result->fetch_assoc()['maxID'] + 1 : 1;
    return 'C' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

function titleCase($string)
{
    return ucwords(strtolower(trim($string)));
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// add customer
if ($action === 'add') {
    $custID = generateCustomerID($connect);

    // apply title case
    $custName = titleCase($_POST['custName']);

    $stmt = $connect->prepare("INSERT INTO customer (custID, custName, custPhone, custEmail) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $custID, $custName, $_POST['custPhone'], $_POST['custEmail']);

    $stmt->execute() ? header("Location: customer.php?success=added") : header("Location: customer.php?error=add");
}

// edit customer
elseif ($action === 'edit') {
    // apply title case
    $custName = titleCase($_POST['custName']);

    $stmt = $connect->prepare("UPDATE customer SET custName=?, custPhone=?, custEmail=? WHERE custID=?");
    $stmt->bind_param("ssss", $custName, $_POST['custPhone'], $_POST['custEmail'], $_POST['id']);
    $stmt->execute() ? header("Location: customer.php?success=updated") : header("Location: customer.php?error=update");
}

// delete customer
elseif ($action === 'delete') {
    $stmt = $connect->prepare("DELETE FROM customer WHERE custID = ?");
    $stmt->bind_param("s", $_POST['id']);
    $stmt->execute() ? header("Location: customer.php?success=deleted") : header("Location: customer.php?error=delete");
}
?>
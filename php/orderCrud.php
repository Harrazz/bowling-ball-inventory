<?php
session_start();
include "connection.php";

// generate order id
function generateOrderID($connect)
{
    $sql = "SELECT MAX(CAST(SUBSTRING(orderID, 2) AS UNSIGNED)) AS maxID FROM orders WHERE orderID LIKE 'O%'"; //retrive max order number from existing order
    $result = $connect->query($sql);
    $newNumber = $result && $result->num_rows > 0 ? $result->fetch_assoc()['maxID'] + 1 : 1; //calculate the next order ID (+1)
    return 'O' . str_pad($newNumber, 3, '0', STR_PAD_LEFT); //return the formatted order of order ID
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// add order
if ($action === 'add') {
    $orderID = generateOrderID($connect);

    // SQL statement to insert order details into db
    $stmt = $connect->prepare("INSERT INTO orders (orderID, usersID, productID, qty, orderDate, orderTime, totAmount, payMethod) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissds", $orderID, $_POST['usersID'], $_POST['productID'], $_POST['qty'], $_POST['orderDate'], $_POST['orderTime'], $_POST['totAmount'], $_POST['payMethod']);

    if ($stmt->execute()) {
        // Deduct product when order is made
        $updateStock = $connect->prepare("UPDATE product SET qty = GREATEST(qty - ?, 0) WHERE productID = ?");
        $updateStock->bind_param("is", $_POST['qty'], $_POST['productID']);
        $updateStock->execute();

        header("Location: orders.php?success=added"); //redirect to order page with success
        exit();
    } else {
        header("Location: orders.php?error=add"); //redirect to order page with error
    }
}

?>
<?php
session_start();
include "connection.php";

// generate product id
function generateProductID($connect)
{
    $sql = "SELECT MAX(CAST(SUBSTRING(productID, 2) AS UNSIGNED)) AS maxID FROM product WHERE productID LIKE 'B%'"; //retrieve highest id from db
    $result = $connect->query($sql);
    $newNumber = $result && $result->num_rows > 0 ? $result->fetch_assoc()['maxID'] + 1 : 1; //calculate next product id
    return 'B' . str_pad($newNumber, 3, '0', STR_PAD_LEFT); //return formatted product id
}

// uppercase first letter
function titleCase($string)
{
    return ucwords(strtolower(trim($string)));
}

$action = $_POST['action'] ?? $_GET['action'] ?? ''; //capture action type from POST or GET request

// add product
if ($action === 'add') {
    $productID = generateProductID($connect);

    // apply title case
    $brand = titleCase($_POST['brand']);
    $model = titleCase($_POST['model']);

    // sql query to insert product detials into db
    $stmt = $connect->prepare("INSERT INTO product (productID, suppID, shelf, brand, model, weight, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssidi", $productID, $_POST['suppID'], $_POST['shelf'], $brand, $model, $_POST['weight'], $_POST['price'], $_POST['qty']);

    //execute query and redirect to product page
    $stmt->execute() ? header("Location: products.php?success=added") : header("Location: products.php?error=add");
}

// edit product
elseif ($action === 'edit') {
    // apply title case
    $brand = titleCase($_POST['brand']);
    $model = titleCase($_POST['model']);

    // sql query to update product detials into db
    $stmt = $connect->prepare("UPDATE product SET suppID=?, shelf=?, brand=?, model=?, weight=?, price=?, qty=? WHERE productID=?");
    $stmt->bind_param("ssssidis", $_POST['suppID'], $_POST['shelf'], $brand, $model, $_POST['weight'], $_POST['price'], $_POST['qty'], $_POST['id']);
    
    //execute query and redirect to product page
    $stmt->execute() ? header("Location: products.php?success=updated") : header("Location: products.php?error=update");
}

// delete product
elseif ($action === 'delete') {
    // query to delete product from db
    $stmt = $connect->prepare("DELETE FROM product WHERE productID = ?");
    $stmt->bind_param("s", $_POST['id']);
    $stmt->execute() ? header("Location: products.php?success=deleted") : header("Location: products.php?error=delete");
}
?>
<?php
session_start();
include "connection.php";

// generate supplier id 
function generateSupplierID($connect)
{
    $sql = "SELECT MAX(CAST(SUBSTRING(suppID, 4) AS UNSIGNED)) AS maxID FROM supplier WHERE suppID LIKE 'SUP%'"; //retrieve max supplier id from existing id
    $result = $connect->query($sql);
    $newNumber = $result && $result->num_rows > 0 ? $result->fetch_assoc()['maxID'] + 1 : 1; //calculate nex supplier id (+1)
    return 'SUP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

// uppercase the first letter
function titleCase($string)
{
    return ucwords(strtolower(trim($string)));
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// add supplier
if ($action === 'add') {
    $suppID = generateSupplierID($connect);

    // apply title case
    $suppName = titleCase($_POST['suppName']);
    $suppAddress = titleCase($_POST['suppAddress']);

    // query to insert supplier details into db
    $stmt = $connect->prepare("INSERT INTO supplier (suppID, suppName, suppPhone, suppEmail, suppAddress, suppStatus) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $suppID, $suppName, $_POST['suppPhone'], $_POST['suppEmail'], $suppAddress, $_POST['suppStatus']);

    // excute query and redirect to supplier.page
    $stmt->execute() ? header("Location: suppliers.php?success=added") : header("Location: suppliers.php?error=add");
}

// edit supplier
elseif ($action === 'edit') {
    // apply title case
    $suppName = titleCase($_POST['suppName']);
    $suppAddress = titleCase($_POST['suppAddress']);

    // query to update supplier details into db
    $stmt = $connect->prepare("UPDATE supplier SET suppName=?, suppPhone=?, suppEmail=?, suppAddress=?, suppStatus=? WHERE suppID=?");
    $stmt->bind_param("ssssss", $suppName, $_POST['suppPhone'], $_POST['suppEmail'], $_POST['suppAddress'], $_POST['suppStatus'], $_POST['suppID']);

    // excute query and redirect to supplier.page
    $stmt->execute() ? header("Location: suppliers.php?success=updated") : header("Location: suppliers.php?error=update");
}
?>
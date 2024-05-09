<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "exam";
$port = 8111;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ProductID= $_POST["ProductID"];
    $ProductName = $_POST["ProductName"];
    $Description = $_POST["Description"];
    $UnitPrice = $_POST["UnitPrice"];
    $Quantity = $_POST["Quantity"];
    $Category = $_POST["Category"];

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["Image"]["name"]);
    move_uploaded_file($_FILES["Image"]["tmp_name"], $targetFile);

    $sql = "INSERT INTO products (ProductID, ProductName, Description, UnitPrice, Quantity, Category, Image) 
            VALUES ('$ProductID', '$ProductName' , '$Description', '$UnitPrice', '$Quantity' ,'$Category', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: ";
    }
}

$conn->close();
?>

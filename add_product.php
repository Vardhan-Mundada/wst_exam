<?php
// Connect to the database (replace with your database credentials)
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "trial";
$port = 8111;

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $availability = isset($_POST["availability"]) ? 1 : 0;

    // Upload image file
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    // Insert product data into the database
    $sql = "INSERT INTO product (name, description, price, category, availability, image) 
            VALUES ('$name', '$description', '$price', '$category', '$availability', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

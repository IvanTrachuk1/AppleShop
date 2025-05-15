<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "apple";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $database);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// Отримуємо дані з форми
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$product = $_POST['product'];

// SQL-запит для вставки даних
$sql = "INSERT INTO orders (name, phone, address, product) VALUES (?, ?, ?, ?)";

// Використання підготовленого запиту
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $phone, $address, $product);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

// Закриваємо з'єднання
$stmt->close();
$conn->close();
?>
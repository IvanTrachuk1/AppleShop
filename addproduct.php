<?php
// Увімкнення відображення помилок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Параметри підключення до бази даних
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apple";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення до бази даних: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["productName"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Завантаження файлу зображення
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die("Помилка завантаження файлу.");
    }

    // Перевірка, чи товар із такою ж назвою вже існує (уникнення дублювання)
    $check_sql = "SELECT COUNT(*) FROM products WHERE productName = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        die("Такий товар уже існує!");
    }

    // Запит на додавання товару
    $sql = "INSERT INTO products (productName, category, price, description, image) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $productName, $category, $price, $description, $target_file);

    if ($stmt->execute()) {
        echo "Новий товар успішно додано!";
    } else {
        die("Помилка додавання товару: " . $conn->error);
    }

    $stmt->close();
}

$conn->close();
?>
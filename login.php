<?php
// Увімкнення помилок для діагностики
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Параметри підключення до бази даних
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apple";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$error = ""; // Змінна для повідомлення про помилку

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Запит до таблиці Login
    $stmt = $conn->prepare("SELECT password FROM Login WHERE login = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            session_start();
            $_SESSION['user'] = $email;

            // Успішний вхід: перенаправлення на сторінку
            header("Location: adminindex.html");
            exit();
        } else {
            $error = "Wrong login or password.";
        }
    } else {
        $error = "No user with this login.";
    }

    
}

$conn->close();

// Якщо є помилка, додаємо її у відповідь
if (!empty($error)) {
    header("HTTP/1.1 401 Unauthorized");
    header("X-Error-Message: $error"); // Виведення повідомлення через заголовок
    echo "<script>alert('$error');</script>"; // Додаткове відображення у вигляді alert
}
?>
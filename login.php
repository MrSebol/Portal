<?php
session_start();

// Połączenie z bazą danych
$db = new mysqli('localhost', 'root', '', 'Portal');

// Sprawdzenie połączenia
if ($db->connect_error) {
    die("Błąd połączenia z bazą danych: " . $db->connect_error);
}

// Pobranie danych z formularza
$email = $_POST['email'];
$password = $_POST['password'];

// Pobranie hasła z bazy danych
$stmt = $db->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Sprawdzenie hasła
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id']; // Zapisanie ID użytkownika w sesji
    header("Location: indexglowna.html"); // Przekierowanie na stronę główną po udanym logowaniu
    exit();
} else {
    echo "Błędny adres e-mail lub hasło!";
}

// Zamknięcie połączenia
$db->close();
?>

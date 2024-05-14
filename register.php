<?php
// Połączenie z bazą danych
$db = new mysqli('localhost', 'root', '', 'Portal');

// Sprawdzenie połączenia
if ($db->connect_error) {
    die("Błąd połączenia z bazą danych: " . $db->connect_error);
}

// Pobranie danych z formularza
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hashowanie hasła
$hashed_password = password_hash($password, PASSWORD_ARGON2I);

// Wstawienie danych do bazy danych
$stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Konto zostało założone pomyślnie!";
} else {
    echo "Błąd podczas rejestracji: " . $db->error;
}

// Zamknięcie połączenia
$db->close();
?>


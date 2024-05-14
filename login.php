<?php
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
$stmt = $db->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Sprawdzenie hasła
if ($user && password_verify($password, $user['password'])) {
    echo "Zalogowano pomyślnie!";
} else {
    echo "Błędny adres e-mail lub hasło!";
}

// Zamknięcie połączenia
$db->close();
?>

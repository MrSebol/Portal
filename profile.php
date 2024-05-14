<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Twój profil</title>
   
</head>
<body>
    <h1>Twój profil</h1>
    <form action="update_profile.php" method="post" enctype="multipart/form-data">
        <input type="file" name="profile_picture" accept="image/*"><br>
        <textarea name="about_me" placeholder="Opowiedz coś o sobie..."></textarea><br>
        <button type="submit">Zapisz zmiany</button>
    </form>
</body>
</html>
<?php
// Połączenie z bazą danych
$db = new mysqli('localhost', 'root', '', 'Portal');

// Sprawdzenie połączenia
if ($db->connect_error) {
    die("Błąd połączenia z bazą danych: " . $db->connect_error);
}

// Pobranie danych opisu użytkownika i przesłanego zdjęcia
$about_me = $_POST['about_me'];
$profile_picture = $_FILES['profile_picture'];

// Wstawienie danych do bazy danych
$stmt = $db->prepare("UPDATE users SET about_me = ? WHERE id = ?");
$stmt->bind_param("si", $about_me, $user_id); 
$stmt->execute();

// Obsługa przesłanego zdjęcia
if ($profile_picture['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($profile_picture['name']);

    if (move_uploaded_file($profile_picture['tmp_name'], $upload_file)) {
        echo "Zdjęcie zostało przesłane pomyślnie.";
    } else {
        echo "Wystąpił problem podczas przesyłania zdjęcia.";
    }
}


$db->close();
?>

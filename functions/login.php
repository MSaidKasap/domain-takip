<?php
require_once 'connection.php'; 
session_start();

function login($user_mail, $user_password) {
    global $db;
    $hashedPassword = md5($user_password); 
    // is_delete kolonu kontrol edilecek
    $query = "SELECT * FROM users WHERE user_mail = :user_mail AND user_password = :user_password AND is_delete = 0";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_mail', $user_mail);
    $stmt->bindParam(':user_password', $hashedPassword);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['user_name'];

        $sessionId = session_id();
        $username = $user['user_name'];
        
        // Oturum verisini ekleme/kayıt güncelleme
        $query = "INSERT INTO session_data (session_id, user_id, username) VALUES (:session_id, :user_id, :username)
                  ON DUPLICATE KEY UPDATE username = VALUES(username)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->bindParam(':user_id', $user['id']);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Role_id'ye göre yönlendirme
        header("Location: ../index.php?status=ok");
        exit();
    } else {
        header("Location: ../index.php?status=no");
    }
}

// Form gönderildi mi kontrol edelim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formdan gelen verileri alalım
    $user_mail = $_POST['user_mail'];
    $user_password = $_POST['user_password'];

    // Giriş yapmaya çalış
    login($user_mail, $user_password);
}
?>

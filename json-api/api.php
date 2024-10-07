<?php
header('Content-Type: application/json');
include '../functions/connection.php'; // Veritabanı bağlantısını dahil et

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'customers') {
    // Müşterileri al
    $stmt = $db->query("SELECT * FROM customers");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($customers);
} elseif ($action == 'payments') {
    // Ödemeleri al
    $stmt = $db->query("SELECT * FROM payments");
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($payments);
} elseif ($action == 'products') {
    // Ürünleri al
    $stmt = $db->query("SELECT * FROM food_items");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} elseif ($action == 'sales') {
    // Ürünleri al
    $stmt = $db->query("SELECT * FROM sales  ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} else {
    echo json_encode(['message' => 'Invalid action']);
}

if ($action == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanında kontrol et
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password' => md5($password)]); // MD5 ile şifreleme

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['status' => 'success', 'user' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    }
}

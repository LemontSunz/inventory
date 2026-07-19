<?php
$env = file_get_contents(__DIR__ . '/.env');
preg_match('/^DB_HOST=(.*)$/m', $env, $h);
preg_match('/^DB_PORT=(.*)$/m', $env, $p);
preg_match('/^DB_DATABASE=(.*)$/m', $env, $d);
preg_match('/^DB_USERNAME=(.*)$/m', $env, $u);
preg_match('/^DB_PASSWORD=(.*)$/m', $env, $w);
$host = trim($h[1] ?? '127.0.0.1');
$port = trim($p[1] ?? '3306');
$db = trim($d[1] ?? '');
$user = trim($u[1] ?? 'root');
$pass = trim($w[1] ?? '');
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare('INSERT INTO incoming_goods (receiving_code, container_number, receiving_date, supplier_id, supplier, delivery_order_number, description, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
    $stmt->execute(['TEST-001', 'CNT-01', date('Y-m-d'), null, 'Test Supplier', 'DO-01', 'Test entry', 2]);
    $incomingId = $pdo->lastInsertId();
    $stmt = $pdo->prepare('INSERT INTO incoming_goods_details (incoming_goods_id, item_id, quantity_received, rack_location_id, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())');
    $stmt->execute([$incomingId, 7, 1, 1]);
    $pdo->rollBack();
    echo "FK test succeeded\n";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "FK test failed: " . $e->getMessage() . "\n";
    exit(1);
}

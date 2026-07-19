<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=inventory;charset=utf8mb4', 'root', '');
$stmt = $pdo->query('SHOW COLUMNS FROM incoming_goods');
foreach ($stmt as $row) {
    echo $row['Field'] . ' ' . $row['Type'] . ' ' . ($row['Null'] === 'NO' ? 'NOT NULL' : 'NULL') . "\n";
}

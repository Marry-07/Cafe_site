<?php
if (!function_exists('mb_strlen')) {
  function mb_strlen($s, $enc = 'UTF-8') {
    preg_match_all('/./us', $s, $m);
    return count($m[0]);
  }
}



header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

$name  = $_POST['name']  ?? '';
$tel   = $_POST['tel']   ?? '';
$email = $_POST['email'] ?? '';

$entry = ['name' => $name, 'tel' => $tel, 'email' => $email];
$line = json_encode($entry, JSON_UNESCAPED_UNICODE) . PHP_EOL;
$file = __DIR__ . '/users.txt';

if (file_put_contents($file, $line, FILE_APPEND | LOCK_EX) === false) {
  http_response_code(500);
  echo json_encode(['error' => 'Cannot write to users.txt']);
  exit;
}

echo json_encode(['success' => true]);


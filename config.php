<?php
declare(strict_types=1);
session_start();

/*
 * Update these values for Laragon or your chosen hosting provider.
 * Never commit or share real production database credentials.
 */
const DB_HOST = '127.0.0.1';
const DB_NAME = 'irm_church';
const DB_USER = 'root';
const DB_PASS = ''; // Laragon default is often blank; change on production.
const SITE_NAME = 'IRM Church';
const SITE_LOCATION = 'Minanga, Aparri, Cagayan';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Check config.php and confirm the database has been imported.');
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION['csrf_token'] ?? '') . '">';
}
function verify_csrf(): void {
    $sent = $_POST['csrf_token'] ?? '';
    if (!is_string($sent) || !hash_equals($_SESSION['csrf_token'] ?? '', $sent)) {
        http_response_code(419);
        exit('Session expired or invalid form token. Please go back and try again.');
    }
}
function is_admin(): bool {
    return isset($_SESSION['admin_id']) && is_numeric($_SESSION['admin_id']);
}
function require_admin(): void {
    if (!is_admin()) {
        header('Location: login.php');
        exit;
    }
}
function flash(string $message, string $type = 'success'): void {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}
function take_flash(): ?array {
    if (empty($_SESSION['flash'])) return null;
    $value = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $value;
}

<?php
session_start();
define('USERS_FILE', __DIR__ . '/users.json');

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function loadUsers(): array {
    if (!file_exists(USERS_FILE)) return [];
    $data = json_decode(file_get_contents(USERS_FILE), true);
    return is_array($data) ? $data : [];
}

function saveUsers(array $users): bool {
    $json = json_encode(array_values($users), JSON_PRETTY_PRINT);
    return file_put_contents(USERS_FILE, $json, LOCK_EX) !== false;
}

function findUserByEmail(string $email): ?array {
    foreach (loadUsers() as $user) {
        if (strcasecmp($user['email'], $email) === 0) return $user;
    }
    return null;
}
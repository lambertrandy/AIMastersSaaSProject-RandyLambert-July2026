<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function check(): bool
    {
        return self::id() !== null;
    }

    public static function id(): ?int
    {
        $userId = Session::get('auth_user_id');

        return is_int($userId) ? $userId : (is_numeric($userId) ? (int) $userId : null);
    }

    public static function login(int $userId): void
    {
        session_regenerate_id(true);
        Session::put('auth_user_id', $userId);
    }

    public static function logout(): void
    {
        Session::forget('auth_user_id');
        $_SESSION = [];

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}

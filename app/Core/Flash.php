<?php

class Flash
{
    private const KEY_MESSAGE = 'flash';
    private const KEY_ERRORS  = 'flash_errors';
    private const KEY_OLD     = 'flash_old';

    // $type: success | danger | warning | info
    public static function set(string $type, string $message): void
    {
        $_SESSION[self::KEY_MESSAGE] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    public static function success(string $message): void
    {
        self::set('success', $message);
    }

    public static function error(string $message): void
    {
        self::set('danger', $message);
    }

    // Simpan error per-field + input lama (dipakai saat validasi gagal)
    public static function withForm(array $errors, array $old): void
    {
        $_SESSION[self::KEY_ERRORS] = $errors;
        $_SESSION[self::KEY_OLD]    = $old;
    }

    public static function has(): bool
    {
        return isset($_SESSION[self::KEY_MESSAGE]);
    }

    // Ambil pesan lalu hapus dari session (tampil sekali)
    public static function pull(): ?array
    {
        $message = $_SESSION[self::KEY_MESSAGE] ?? null;
        unset($_SESSION[self::KEY_MESSAGE]);

        return $message;
    }

    public static function pullErrors(): array
    {
        $errors = $_SESSION[self::KEY_ERRORS] ?? [];
        unset($_SESSION[self::KEY_ERRORS]);

        return $errors;
    }

    public static function pullOld(): array
    {
        $old = $_SESSION[self::KEY_OLD] ?? [];
        unset($_SESSION[self::KEY_OLD]);

        return $old;
    }
}

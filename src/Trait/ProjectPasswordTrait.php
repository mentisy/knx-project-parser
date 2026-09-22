<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Trait;

use SensitiveParameter;

trait ProjectPasswordTrait
{
    /**
     * Hash the plain-text password provided. For use in opening password-protected project files.
     *
     * @param string $plainPassword Plain password to hash.
     * @return string
     */
    protected function hashPassword(
        #[SensitiveParameter]
        string $plainPassword,
    ): string {
        $algorithm = 'sha256';
        $passwordBytes = mb_convert_encoding($plainPassword, 'UTF-16LE', 'UTF-8');
        $salt = '21.project.ets.knx.org';
        $iterations = 65536;
        $key_length = 32;
        $key = hash_pbkdf2($algorithm, $passwordBytes, $salt, $iterations, $key_length, true);

        return base64_encode($key);
    }
}

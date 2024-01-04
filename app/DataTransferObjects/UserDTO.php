<?php

namespace App\DataTransferObjects;

class UserDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $name,
        public readonly ?string $cpf,
        public readonly ?string $email,
        public readonly ?string $password,
        public readonly ?string $role,
    ) {
    }
}

<?php

namespace App\Dto;

class UserCreateDto {

    public string $name;
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
    }
}
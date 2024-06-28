<?php

require_once __DIR__ . "/../models/User.php";

class UserController
{
    public function create($name, $email, $phone, $photoName): User
    {
        $user = new User(null, $name, $email, $phone, $photoName);
        return User::create($user);
    }

    public function read($id): ?User
    {
        $user = User::read($id);
        if ($user) {
            return $user;
        }
    }

    public function readAll(): array
    {
        return User::readAll();
    }

    public function update(User $user): void
    {
        User::update($user);
    }

    public function delete($id): void
    {
        User::delete($id);
    }
}

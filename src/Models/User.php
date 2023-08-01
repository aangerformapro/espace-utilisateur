<?php

declare(strict_types=1);

namespace Models;

class User extends BaseModel implements \JsonSerializable, \Stringable
{
    protected int $id;

    protected string $username;

    protected string $firstname;

    protected string $lastname;

    protected string $email;

    public function __construct(array $data)
    {
        $this->id        = (int) $data['id'];
        $this->firstname = $data['firstname'];
        $this->lastname  = $data['lastname'];
        $this->email     = $data['email'];
        $this->username  = $data['username'];
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public static function connectUser(string $username, string $password): ?self
    {
        $stmt = static::getConnection()->prepare(
            'SELECT * FROM USERS WHERE username=?'
        );

        if ($stmt->execute([$username]))
        {
            if ($user = $stmt->fetch(\PDO::FETCH_ASSOC))
            {
                if (password_verify($password, $user['password']))
                {
                    return new static($user);
                }
            }
        }

        return null;
    }

    public static function createUser(array $data): bool
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt             = static::getConnection()->prepare(
            'INSERT INTO users (username, firstname, lastname, email, password) ' .
            'VALUES(:username, :firstname, :lastname, :email, :password)'
        );

        try
        {
            return $stmt->execute($data);
        } catch (\Throwable $e)
        {
            return false;
        }
    }

    public function jsonSerialize()
    {
        return [
            'id'        => $this->id,
            'username'  => $this->username,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'email'     => $this->email,
        ];
    }

    public function toArray(): array
    {
        return $this->jsonSerialize();
    }
}

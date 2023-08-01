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
            'SELECT * FROM users WHERE username=?'
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

    public static function hasUsers(int $id = null): bool
    {
        $query = 'SELECT COUNT(id) AS count FROM users';

        if ( ! is_null($id))
        {
            $query .= ' WHERE id=:id';
            $stmt = static::getConnection()->prepare($query);
            $stmt->bindValue(':id', $id);
        } else
        {
            $stmt = static::getConnection()->prepare($query);
        }

        $stmt->execute();

        if ($result = $stmt->fetch())
        {
            return $result['count'] > 0;
        }

        return false;
    }

    protected static function createTable(\PDO $pdo)
    {
        $query = 'CREATE TABLE IF NOT EXISTS users (' .
            'id int(11) NOT NULL AUTO_INCREMENT,' .
            'username varchar(255) NOT NULL,' .
            'firstname varchar(255) NOT NULL,' .
            'lastname varchar(255) NOT NULL,' .
            'email varchar(255) NOT NULL,' .
            'password varchar(255) NOT NULL,' .
            'PRIMARY KEY (id),' .
            'UNIQUE KEY username (username),' .
            'UNIQUE KEY email (email)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

        $pdo->query($query);
    }
}

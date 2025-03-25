<?php
include_once __DIR__ . '/DB.php';
include_once __DIR__ . '/helper.php';

class User
{
    static public function all($limit = 5, $offset = 0, $search = "")
    {
        $sql = "SELECT * FROM users";
        $data = [];

        if (!empty($search)) {
            $sql .= " WHERE name LIKE :search";
            $data['search'] = "%$search%";
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = DB::getConnection()->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        if (!empty($search)) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function count($search = "")
    {
        $sql = "SELECT COUNT(*) as total FROM users";
        $data = [];

        if (!empty($search)) {
            $sql .= " WHERE name LIKE :search";
            $data['search'] = "%$search%";
        }

        $stmt = DB::getConnection()->prepare($sql);

        if (!empty($search)) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    static public function create($dataCreate)
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        return DB::execute($sql, $dataCreate);
    }

    static public function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $user = DB::execute($sql, ['id' => $id]);
        return count($user) > 0 ? $user[0] : [];
    }

    static public function update($dataUpdate)
    {
        $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        return DB::execute($sql, $dataUpdate);
    }

    static public function destroy($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        return DB::execute($sql, ['id' => $id]);
    }

    static public function register($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return self::create(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);
    }

    static public function login($name, $password)
    {
        $sql = "SELECT * FROM users WHERE name = :name";
        $users = DB::execute($sql, ['name' => $name]);

        if (count($users) > 0) {
            $user = $users[0];

            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }

    static public function logout()
    {
        session_destroy();
        unset($_SESSION['user']);
    }
}

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

        // Ép kiểu số nguyên và truyền trực tiếp vào SQL
        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        return DB::execute($sql, $data);
    }

    static public function count($search = "")
    {
        $sql = "SELECT COUNT(*) as total FROM users";
        $data = [];

        if (!empty($search)) {
            $sql .= " WHERE name LIKE :search";
            $data['search'] = "%$search%";
        }

        $result = DB::execute($sql, $data);
        return $result[0]['total'] ?? 0;
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
        echo "Mật khẩu nhập: $password <br>";
        echo "Mật khẩu hash: $hashedPassword <br>";
    }

    static public function login($name, $password)
    {
        $sql = "SELECT * FROM users WHERE name = :name";
        $users = DB::execute($sql, ['name' => $name]);

        if (count($users) > 0) {
            $user = $users[0];

            // 🛠 DEBUG - Xem mật khẩu thực tế trong DB
            echo "🔍 Mật khẩu nhập vào: $password <br>";
            echo "🔍 Mật khẩu hash trong DB: " . $user['password'] . "<br>";

            if (password_verify($password, $user['password'])) {
                echo "✅ Mật khẩu khớp!";
                $_SESSION['user'] = $user;
                return true;
            } else {
                echo "❌ Mật khẩu không khớp!";
            }
        } else {
            echo "❌ Không tìm thấy user!";
        }
        return false;
    }



    static public function logout()
    {
        session_destroy();
        unset($_SESSION['user']);
    }
}

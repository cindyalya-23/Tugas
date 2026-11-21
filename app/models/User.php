<?php

class User extends Model
{
    protected string $table = 'tb_users';
    protected string $pk = 'user_id';

    public function usernameAda(string $username): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tb_users WHERE user_name = :u");
        $stmt->execute([':u' => $username]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function register(string $username, string $password, string $namaLengkap): void
    {
        $sql = "INSERT INTO tb_users SET user_name=:n, user_password=:p, user_namalengkap=:l, user_aktif=1";
        $this->db->prepare($sql)->execute([
            ':n' => $username,
            ':p' => password_hash($password, PASSWORD_DEFAULT),
            ':l' => $namaLengkap,
        ]);
    }

    public function login(string $username, string $password): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM tb_users WHERE user_name = :u AND user_aktif = 1");
        $stmt->execute([':u' => $username]);
        $u = $stmt->fetch();

        if ($u && password_verify($password, $u['user_password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id'   => (int) $u['user_id'],
                'name' => $u['user_name'],
                'nama' => $u['user_namalengkap'],
            ];
            return true;
        }
        return false;
    }
}

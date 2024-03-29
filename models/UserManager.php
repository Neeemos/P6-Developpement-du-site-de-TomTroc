<?php

class UserManager extends AbstractEntityManager
{
    public function createUser(User $user): bool
    {
        $existingUserCount = $this->getUserCountByEmailOrPseudo($user->getEmail(), $user->getPseudo());

        if ($existingUserCount > 0) {
            return false;
        }

        // Insert the new user into the database
        $sql = "INSERT INTO users (email, password, pseudo, num_livre, register_date) VALUES (:email, :password, :pseudo, 0, NOW())";
        $result = $this->db->query($sql, [
            "pseudo" => $user->getPseudo(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
        ]);
        if ($result->rowCount() > 0) {
            return true;
        }
        return false;
    }

    private function getUserCountByEmailOrPseudo(string $email, string $pseudo): int
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE pseudo = :pseudo OR email = :email";
        $result = $this->db->query($sql, [
            'pseudo' => $pseudo,
            'email' => $email
        ]);

        $row = $result->fetch();
        return $row['count'];
    }

    public function loginUser(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $this->db->query($sql, [
            "email" => $email
        ]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * Récupère un user par son email.
     * @param string $email
     * @return ?User
     */
    public function getUserByEmail(string $email): ?User
    {

        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }
}
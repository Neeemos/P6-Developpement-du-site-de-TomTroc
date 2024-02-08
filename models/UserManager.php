<?php

class UserManager extends AbstractEntityManager
{
    public function createUser(User $user): bool
    {
        $sqlUser = "SELECT pseudo, email FROM users WHERE pseudo = :pseudo OR email = :email";
        $resultUser = $this->db->query($sqlUser, [
            'pseudo' => $user->getPseudo(),
            'email' => $user->getEmail()
        ]);
        $users = [];
        foreach ($resultUser as $row) {
            $users[] = new User($row);

            if (strtolower($user->getPseudo()) == strtolower($row["pseudo"]) && strtolower($user->getEmail()) == strtolower($row["email"])) {
                $_SESSION["error"]["pseudo"] = "Ce pseudo est déja utilisé";
                $_SESSION["error"]["email"] = "Cette email est déja utilisée";
            } elseif (strtolower($user->getPseudo()) == strtolower($row["pseudo"])) {
                $_SESSION["error"]["pseudo"] = "Ce pseudo est déja utilisé";
            } elseif (strtolower($user->getEmail()) == strtolower($row["email"])) {
                $_SESSION["error"]["email"] = "Cette email est déja utilisée";
            }
        }

        //Si le tableau users est vide alors tout est unique on peut ajouter un nouvel utilisateur
        if (!$users) {
            $sql = "INSERT INTO users (email, password, pseudo, num_livre, register_date) VALUES (:email, :password, :pseudo, 0, NOW())";
            $result = $this->db->query($sql, [
                "pseudo" => $user->getPseudo(),
                "email" => $user->getEmail(),
                "password" => $user->getPassword(),
            ]);
            return $result->rowCount() > 0;
        }
        return 0;
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
    public function getUserByEmail(string $email) : ?User 
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
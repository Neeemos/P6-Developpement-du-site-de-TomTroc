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

    /**
     * Récupère les données de la page public par l'id du compte
     * @param int|null $id
     * @return User|null
     */
    public function getUserById(?int $id = null)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $params = ["id" => $id];

        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
        return new User($result);
    }

    public function getUserMessages()
    {
        $sql = "SELECT * FROM messages WHERE id_sender = :id OR id_receiver = :id ORDER BY date DESC";
        $params = ["id" => $_SESSION['user']->getId()];
        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $messages = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $messages[] = new message($row);
        }

        return $messages;
    }
    public function getUserListMessage()
    {
        $sql = "
        WITH unique_ids AS (
            SELECT id_sender AS id
            FROM messages
            WHERE (id_sender = :id OR id_receiver = :id)
                AND id_sender <> :current_user_id
            UNION
            SELECT id_receiver AS id
            FROM messages
            WHERE (id_sender = :id OR id_receiver = :id)
                AND id_receiver <> :current_user_id
        )
        SELECT u.*
        FROM users u
        JOIN unique_ids ui ON u.id = ui.id
        ORDER BY u.id;
    ";

        $params = [
            "id" => $_SESSION['user']->getId(),
            "current_user_id" => $_SESSION['user']->getId()
        ];
        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($row); // Store the row of user information
        }

        return $users;
    }
}

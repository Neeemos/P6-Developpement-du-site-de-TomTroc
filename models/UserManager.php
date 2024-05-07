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

    public function getUserListMessage()
    {
        $sql = "
        SELECT 
        m.id_sender,
        m.id_receiver,
        m.message AS message,
        m.date AS date,
        u.pseudo AS pseudo,
        u.image AS image,
        :user_id AS session_id
    FROM 
        messages m
    JOIN 
        users u ON u.id = CASE 
                            WHEN m.id_sender = :user_id THEN m.id_receiver
                            ELSE m.id_sender
                         END
    WHERE 
        (m.id_receiver = :user_id OR m.id_sender = :user_id)
        AND m.date = (
            SELECT MAX(date)
            FROM messages
            WHERE (id_sender = m.id_sender AND id_receiver = m.id_receiver)
                OR (id_sender = m.id_receiver AND id_receiver = m.id_sender)
        )
    ORDER BY 
        date DESC;  ";

        $params = [
            "user_id" => $_SESSION['user']->getId()
        ];
        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $list = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] = $row;
        }

        return $list;
    }
    public function getConversationMessages(int $conversationId)
    {
        $sql = "SELECT messages.*, 
        user.image AS image, 
        :user_id AS session_id 
 FROM messages
 LEFT JOIN users AS user ON user.id = :receiver_id
 WHERE (id_sender = :user_id AND id_receiver = :receiver_id) 
    OR (id_sender = :receiver_id AND id_receiver = :user_id) 
 ORDER BY date ASC";

        $params = [
            "user_id" => $_SESSION['user']->getId(),
            "receiver_id" => $conversationId
        ];
        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $conversation = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $conversation[] = $row;
        }

        return $conversation;

    }
    public function addMessage(string $message, int $receiverId)
    {
        $sql = "INSERT INTO messages (id, message, date, id_sender, id_receiver) VALUES (null, :message, NOW(), :id_sender, :id_receiver)";
        $params = [
            "id_sender" => $_SESSION['user']->getId(),
            "id_receiver" => $receiverId,
            "message" => $message
        ];
        $stmt = $this->db->query($sql, $params);

    }
}

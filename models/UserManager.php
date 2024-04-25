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
    /**
     * récupère les messages d'un user
     * @return array
     */
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
        $sql = "SELECT 
        m1.message, 
        m1.date, 
        COALESCE(sender_pseudo.pseudo, receiver_pseudo.pseudo) AS pseudo,
        COALESCE(sender_pseudo.image, receiver_pseudo.image) AS image,
        m1.id_sender, 
        m1.id_receiver,
        :user_id AS session_id
    FROM 
        messages m1
    LEFT JOIN 
        users sender_pseudo 
        ON m1.id_sender <> :user_id AND m1.id_sender = sender_pseudo.id 
    LEFT JOIN 
        users receiver_pseudo 
        ON m1.id_receiver <> :user_id AND m1.id_receiver = receiver_pseudo.id 
    JOIN (
        SELECT 
            MAX(date) AS max_date, 
            CASE
                WHEN id_sender = :user_id THEN id_receiver
                ELSE id_sender
            END AS other_person
        FROM 
            messages
        WHERE 
            id_sender = :user_id OR id_receiver = :user_id
        GROUP BY 
            CASE
                WHEN id_sender = :user_id THEN id_receiver
                ELSE id_sender
            END
    ) m2
    ON (
        m1.date = m2.max_date 
        AND (
            (m1.id_sender = :user_id AND m1.id_receiver = m2.other_person) 
            OR 
            (m1.id_receiver = :user_id AND m1.id_sender = m2.other_person)
        )
    )
    ";

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
        conversation.image AS image, 
        :user_id AS session_id 
 FROM messages
 LEFT JOIN users AS conversation ON conversation.id = :conversation_id
 WHERE (id_sender = :user_id AND id_receiver = :conversation_id) 
    OR (id_sender = :conversation_id AND id_receiver = :user_id) 
 ORDER BY date ASC";

        $params = [
            "user_id" => $_SESSION['user']->getId(),
            "conversation_id" => $conversationId
        ];
        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $conversation = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $conversation[] = $row;
        }

        return $conversation;

    }
}

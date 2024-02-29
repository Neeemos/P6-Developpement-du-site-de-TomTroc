<?php

/**
 * Classe qui gère les articles.
 */
class BookManager extends AbstractEntityManager
{
    /**
     * Récupère les derniers livres.
     * @param int|null $limit : Limite le nombre de livres à récupérer. Par défaut, récupère tous les livres.
     * @return array : un tableau d'objets book.
     */
    public function getLastedBooks(?int $limit = null): array
    {
        $sql = "SELECT livres.*, users.pseudo 
    FROM livres 
    INNER JOIN users ON livres.user_id = users.id 
    ORDER BY livres.id DESC";

        if ($limit !== null && is_int($limit) && $limit > 0) {
            $sql .= " LIMIT $limit";
        }

        $result = $this->db->query($sql);
        $lastsbooks = [];

        foreach ($result as $row) {
            $lastsbooks[] = new Book($row);
        }
        return $lastsbooks;
    }
    /**
     * Récupère le livre par son ID ou l'ID de l'utilisateur.
     * @param int|null $id
     * @param int|null $userId
     * @return Book|null
     */
    public function getBookById(?int $id = null, ?int $userId = null)
    {
        $sql = "SELECT livres.*, users.pseudo, users.image AS userImage
            FROM livres 
            INNER JOIN users ON livres.user_id = users.id";

        if ($id !== null) {
            $sql .= " WHERE livres.id = :id";
            $params = ["id" => $id];
            
            $stmt = $this->db->query($sql, $params);
            $stmt->execute($params);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return null; 
            }
            $book = new Book($result);

            return $book;
        } elseif ($userId !== null) {
            $sql .= " WHERE livres.user_id = :userId ORDER BY livres.id DESC";
            $params = ["userId" => $userId];
          
            $stmt = $this->db->query($sql, $params);
            $stmt->execute(["userId" => $userId]);

            $books = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $books[] = new Book($row);
            }

            return $books;
        } 
    }



}
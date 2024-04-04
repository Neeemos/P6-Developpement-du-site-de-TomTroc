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
        $sql = "SELECT books.*, users.pseudo 
    FROM books 
    INNER JOIN users ON books.user_id = users.id 
    ORDER BY books.id DESC";

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
        $sql = "SELECT books.*, users.pseudo, users.image AS userImage
            FROM books 
            INNER JOIN users ON books.user_id = users.id";

        if ($id !== null) {
            $sql .= " WHERE books.id = :id";
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
            $sql .= " WHERE books.user_id = :userId ORDER BY books.id DESC";
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
    /**
     * Récupère le livre par son nom ou son auteur.
     * @param string $query
     * @return Book|null
     */
    public function getBookByNameOrAutor(?string $query = null)
    {
        $sql = "SELECT * FROM books WHERE title LIKE CONCAT('%', :id, '%') OR author LIKE CONCAT('%', :id, '%')";
        $params = ["id" => $query];

        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $bookFound = [];
        foreach ($result as $row) {
            $bookFound[] = $row;
        }

        $json = json_encode($bookFound);

        return $json;
    }


}
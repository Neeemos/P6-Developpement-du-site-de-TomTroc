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
     * Récupère le livre par son ID.
     * @param int $id
     * @return Book|null
     */
    public function getBookById(?int $id = null): ?Book
    {
        // Prepare the SQL statement with the WHERE condition
        $sql = "SELECT livres.*, users.pseudo, users.image AS userImage
            FROM livres 
            INNER JOIN users ON livres.user_id = users.id 
            WHERE livres.id = :id
            ORDER BY livres.id DESC";


        $resultSql = $this->db->query($sql, ["id" => $id]);
        $resultSql->execute();

        $result = $resultSql->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null; // Return null if no book found
        }
     
        // Create a Book object from the fetched data
        $book = new Book($result);

        return $book;
    }

}
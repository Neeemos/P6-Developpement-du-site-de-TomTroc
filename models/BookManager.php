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
     * Récupère le livre par son ID.
     * @param int $id
     * @return Book|null
     */
    public function getBookById(int $id): ?Book
    {
        $sql = "SELECT books.*, users.pseudo, users.image AS userImage
        FROM books 
        INNER JOIN users ON books.user_id = users.id
        WHERE books.id = :id";

        $params = ["id" => $id];

        $stmt = $this->db->query($sql, $params);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new Book($result);
    }


    /**
     * Récupère les livres par l'ID de l'utilisateur.
     * @param int $userId
     * @return array
     */
    public function getBooksByUserId(int $userId): array
    {
        $sql = "SELECT books.*, users.pseudo, users.image AS userImage
        FROM books 
        INNER JOIN users ON books.user_id = users.id
        WHERE books.user_id = :userId
        ORDER BY books.id DESC";

        $params = ["userId" => $userId];

        $stmt = $this->db->query($sql, $params);
        $stmt->execute(["userId" => $userId]);

        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = new Book($row);
        }

        return $books;
    }


    /**
     * Récupère le livre par son nom ou son auteur.
     * @param string $query
     * @return Book|null|string
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

    /**
     * Update un livre
     * @param book $book
     * @return Book
     */
    public function updateBook(?book $book)
    {
        $sql = "UPDATE books SET title = :title, author = :author, description = :description, available = :available WHERE id = :id";
        $result = $this->db->query($sql, [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'available' => $book->getAvailable(),
            'id' => $book->getId()
        ]);

        if ($result) {
            return $book;
        }
        return new book();
    }
    /**
     * supprime un livre
     * @param book $book
     *
     */
    public function deleteBook(?book $book)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $book->getId()]);
    }
    public function editImage($file_name, $file_tmp, $bookId)
    {

        $sql = "UPDATE books SET image = :image WHERE id = :bookId AND user_id = :id";
        $params = [
            "image" => $file_name,
            "id" => $_SESSION['user']->getId(),
            "bookId" => $bookId
        ];
        $stmt = $this->db->query($sql, $params);
        $upload_dir = 'images/';
        move_uploaded_file($file_tmp, $upload_dir . $file_name);
    }
    public function addBook($book)
    {
        $sql = "INSERT books (user_id, title, author, description, available) VALUES (:userId, :title, :author, :description, :available)";
        $result = $this->db->query($sql, [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'available' => $book->getAvailable(),
            'userId' => $_SESSION['user']->getId()
        ]);
        $lastId = $this->db->getPDO();
        $lastId = $lastId->lastInsertId();
        if ($result) {
            $book->setId($lastId);
            return $book;
        }
        return new book();
    }
}
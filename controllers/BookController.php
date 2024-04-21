<?php

class BookController
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getLastedBooks("4");

        $view = new View("Accueil");
        $view->render("home", ['books' => $books]);
    }

    /**
     * Affiche la page de réferencement des livres.
     * @return void
     */
    public function showBooks(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getLastedBooks();
        $view = new View('ShowBooks');
        $view->render('showBooks', ['books' => $books]);
    }

    /**
     * Affiche la page d'un livre.
     * @param int $id
     * @return void
     */
    public function showBook($id): void
    {
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);
        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        }
        $view = new View('book');
        $view->render('book', ['book' => $book]);
    }

    /**
     * @param string $query
     * @return void
     */
    public function ShowBooksByNameOrAutor($query)
    {
        $bookManager = new BookManager();
        $book = $bookManager->getBookByNameOrAutor($query);

        header('Content-Type: application/json');
        echo $book;
    }

    /**
     * Affiche la page d'edition d'un livre.
     * @param int $id
     * @return void
     */
    public function showEditBook($id): void
    {
        Access::checkUserLoggedIn();

        $bookManager = new BookManager();
        $book = $bookManager->getBookById((int) $id);
        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        Access::validateUserOwnership($_SESSION["user"], $book);

        $view = new View('ShowEditBook');
        $view->render('editBook', ['book' => $book]);
    }

    public function editBook(): void
    {
        Access::checkUserLoggedIn();
        $id = Utils::request("bookId");

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);
        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        }
        Access::validateUserOwnership($_SESSION["user"], $book);
        // Récupération des données du formulaire.
        $title = Utils::request("titre");
        $author = Utils::request("auteur");
        $description = Utils::request("commentaire");
        $available = Utils::request("disponibilite");


        // On vérifie que les données sont valides.
        if (empty($title) || empty($author) || !isset($available) || empty($description) || empty($id)) {
            throw new Exception("Tous les champs sont obligatoires. 3");
        }

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $book->setAvailable($available);

        $result = $bookManager->updateBook($book);

        if (!$result) {
            throw new Exception("Une erreur est survenue lors de la modification du livre.");
        }

        Utils::redirect("editBook", ['id' => $book->getId()]);
    }
    public function deleteBook(): void
    {
        Access::checkUserLoggedIn();

        $id = Utils::request("id");

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        Access::validateUserOwnership($_SESSION["user"], $book);

        $bookManager->deleteBook($book);
        Utils::redirect("profile");
    }
}

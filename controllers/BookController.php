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
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);
        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        }
        $view = new View('ShowEditBook');
        $view->render('editBook', ['book' => $book]);
    }
}
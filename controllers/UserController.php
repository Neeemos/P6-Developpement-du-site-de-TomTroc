<?php

class UserController
{
    public function showProfile(): void
    {
        // Check if user is logged in
        if (!isset($_SESSION["user"])) {
            header("Location: index.php?action=connexion");
            exit();
        }
     
        // Unserialize the user object
        $user = $_SESSION["user"];

        // Fetch user's books
        $bookManager = new BookManager();
        $books = $bookManager->getBookById(null, $user->getId());
        // Render view
        $view = new View('ShowProfile');
        $view->render('profile', ['user' => $user, 'books' => $books]);
    }
}
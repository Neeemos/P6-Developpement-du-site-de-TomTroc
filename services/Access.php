<?php

/**
 * Classe utilitaire : cette classe ne contient que des méthodes statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Utils.
 * Exemple : Access::checkUserLoggedIn(); 
 */
class Access
{
    /**
     * Checks if a user is logged in.
     *
     * @return void 
     */
    public static function checkUserLoggedIn()
    {
        // Check if user session is set
        if (!isset($_SESSION["user"])) {
            // If not, redirect to the login page
            header("Location: index.php?action=login");
            // Exit the script to prevent further execution
            exit();
        }
    }
    /**
     * Check if the user is the owner of the book.
     *
     * @param object $user The user object
     * @param object $book The book object
     * @return void 
     */
    public static function validateUserOwnership($user, $book)
    {
        if ($user->getId() != $book->getUserId()) {
            throw new Exception("Vous ne pouvez pas accéder à ce livre");
        }
    }
}

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
}

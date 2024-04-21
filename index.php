<?php

require_once 'config/autoload.php';
require_once 'config/config.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');
$id = Utils::request('id');
$query = Utils::request('query');
$bookId = Utils::request('bookId');
// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $BookController = new BookController();
            $BookController->showHome();
            break;
        case 'login':
            $adminController = new AdminController();
            $adminController->login();
            break;
        case 'register':
            $adminController = new AdminController();
            $adminController->register();
            break;
        case 'showBooks':
            if (isset($query)) {
                $bookController = new BookController();
                $bookController->ShowBooksByNameOrAutor($query);

            } else {
                $bookController = new BookController();
                $bookController->showBooks();
            }
            break;
        case 'book':
            $bookController = new BookController();
            $bookController->showBook($id);
            break;
        case 'logout':
            $adminController = new AdminController();
            $adminController->disconnectUser();
            break;
        case "profile":
            $userController = new UserController();
            $userController->showProfile();
            break;
        case "public":
            $userController = new UserController();
            $userController->showProfilePublic($id);
            break;
        case "editBook":
            if (isset($bookId)) {
                $bookController = new BookController();
                $bookController->editBook();

            } else {
                $bookController = new BookController();
                $bookController->showEditBook($id);
            }
            break;
        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}

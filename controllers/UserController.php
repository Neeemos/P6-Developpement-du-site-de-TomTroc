<?php

class UserController
{
    public function showProfile(): void
    {
        // Check if user is logged in
        Access::checkUserLoggedIn();

        // Unserialize the user object
        $user = $_SESSION["user"];

        // Fetch user's books
        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUserId((int) $user->getId());
        // Render view
        $view = new View('ShowProfile');
        $view->render('profile', ['user' => $user, 'books' => $books]);
    }
    public function showProfilePublic($id): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUserId((int) $id);

        $userManager = new UserManager();
        $user = $userManager->getUserById((int) $id);
        if (!$user) {
            throw new Exception("L'utilisateur n'existe pas");
        }

        // Render view
        $view = new View('ShowProfilePublic');
        $view->render('public', ['user' => $user, 'books' => $books]);
    }
    public function showMessagerie(): void
    {
        Access::checkUserLoggedIn();
        
        $userManager = new UserManager();
        $messages = $userManager->getUserMessages();
        $listUser = $userManager->getUserListMessage();

        // Render view
        $view = new View('ShowMessagerie');
        $view->render('messagerie', ['messages' => $messages, 'listUser' => $listUser]);
    }
}

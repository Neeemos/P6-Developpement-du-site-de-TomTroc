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

        $view = new View('ShowMessagerie');
        $view->render('messagerie');
    }
    public function showMessagerieList()
    {
        Access::checkUserLoggedIn();

        $userManager = new UserManager();
        $listUser = $userManager->getUserListMessage();

        header('Content-Type: application/json');
        echo json_encode($listUser);
    }

    public function showConversationMessages()
    {
        Access::checkUserLoggedIn();
        $conversationId = (int) Utils::request("userId");
        $userManager = new UserManager();
        $Conversation = $userManager->getConversationMessages((int) $conversationId);

        header('Content-Type: application/json');
        echo json_encode($Conversation);
    }
    public function AddMessage()
    {
        Access::checkUserLoggedIn();
        $message = Utils::request('message');
        $receiverId = Utils::request('userId');
        if (!isset($receiverId) || !isset($message)) {
            throw new Exception("Veuillez remplir tous les champs");
        }
        $userManager = new UserManager();
        $userManager->addMessage($message, $receiverId);
        $returnmessages = array(
            "date" => date("Y-m-d H:i:s"),
            "message" => $message
        );
        header('Content-Type: application/json');
        echo json_encode($returnmessages);

    }
}

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
        $receiverId = (int) Utils::request('userId');
        if (!isset($receiverId) || !isset($message)) {
            throw new Exception("Veuillez remplir tous les champs");
        }
        $userManager = new UserManager();
        $userManager->getUserById($receiverId);
        if (!$receiverId) {
            throw new Exception("L'utilisateur n'existe pas");
        }
        $userManager->addMessage($message, $receiverId);
        $returnmessages = array(
            "date" => date("Y-m-d H:i:s"),
            "message" => $message
        );
        header('Content-Type: application/json');
        echo json_encode($returnmessages);

    }
    public function addImage()
    {
        Access::checkUserLoggedIn();
        $file_name = $_FILES['avatar']['name'];
        $file_tmp = $_FILES['avatar']['tmp_name'];
        // Obtenir l'extension du fichier
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Liste des extensions autorisées
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        if (in_array($file_extension, $allowed_extensions)) {
            $userManager = new UserManager();
            $userManager->addImage($file_name, $file_tmp);
            Utils::redirect("profile");

        } else {
            throw new Exception("Veuillez verifier votre fichier");
        }

    }
    public function userInfo()
    {
        Access::checkUserLoggedIn();
        $userId = Utils::request('userId');
        $userManager = new UserManager();
        $userInfo = $userManager->getUserInfo($userId);
        header('Content-Type: application/json');
        echo json_encode($userInfo);
    }
    public function ajouterLivre()
    {
        Access::checkUserLoggedIn();
        $view = new View('ShowEditBook');
        $view->render('editBook');

    }
}

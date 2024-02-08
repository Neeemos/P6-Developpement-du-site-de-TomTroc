<?php

class AdminController
{

    public function connexion(): void
    {
        $this->checkIfUserIsConnected();
        $view = new View("Connexion");
        $view->render("connexion");
    }
    public function inscription(): void
    {
        $this->checkIfUserIsConnected();
        $view = new View("Inscription");
        $view->render("inscription");
    }
    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected(): void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Utils::redirect("connexion");
        }
    }
    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire.
        $email = Utils::request("email");
        $password = Utils::request("password");

        // On vérifie que les données sont valides.
        if (empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires. ");
        }

        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            throw new Exception("Le mot de passe est incorrect.");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page d'administration.
        Utils::redirect("home");
    }
    public function createUser(): void
    {
        $error = [
            "pseudo" => null,
            "email" => null,
            "password" => null
        ];

        $_SESSION["error"] = $error;
        // mieux vérifier les erreurs
        $pseudo = Utils::request("pseudo");
        $password = Utils::request("password");
        $email = Utils::request("email");

        if (empty($pseudo) || empty($password) || empty($email)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }


        $user = new User([
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
        $userManager = new UserManager();
        $result = $userManager->createUser($user);

        if (!$result) {
            return;
        }

        Utils::redirect("connexion");
    }
}

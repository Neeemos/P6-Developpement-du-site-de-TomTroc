<?php

class AdminController
{

    public function login(): void
    {

        $email = Utils::request("email");
        $password = Utils::request("password");

        if (isset($password) && isset($email)) {
            $this->connectUser();
        }
        $view = new View("login");
        $view->render("login");
    }
    public function register(): void
    {
        $pseudo = Utils::request("pseudo");
        $password = Utils::request("password");
        $email = Utils::request("email");

        if (isset($pseudo) && isset($password) && isset($email)) {
            $this->createUser();
        }

        $view = new View("register");
        $view->render("register");
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


        // On redirige vers la page d'administration.
        Utils::redirect("home");
    }
    public function createUser(): void
    {
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
            throw new Exception("Utilisateur déja existant");
        }

        Utils::redirect("login");
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser(): void
    {
        unset($_SESSION['user']);
        Utils::redirect("home");
    }
}

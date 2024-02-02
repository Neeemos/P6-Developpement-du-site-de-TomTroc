<?php

class AdminController
{

    public function connexion(): void
    {
        $view = new View("Connexion");
        $view->render("connexion");
    }
    public function inscription(): void
    {
        $view = new View("Inscription");
        $view->render("inscription");
    }
}

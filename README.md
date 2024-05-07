![logo](https://image.noelshack.com/fichiers/2024/19/1/1714995203-darwin-vegher.jpg)
# OC - P6 -  TOMTROC  ![logo](http://www.w3.org/Icons/valid-html20.png) - ![logo](http://www.w3.org/Icons/valid-css.png)


Le site devra être développé en PHP, en utilisant le modèle MVC et en respectant les principes de la programmation orientée objet (POO). Ceci permettra une meilleure structure du code et une maintenance aisée à l'avenir. 

En termes de contraintes techniques, elles sont simples : tu dois tout développer en PHP, HTML et CSS sans aucune librairie tierce. Il faut également que tu versionnes ton code avec Git et GitHub.
## Installation 

Clone le projet 

```bash
  git clone https://github.com/Neeemos/P6-Developpement-du-site-de-TomTroc
```
upload le fichier tomtroc.sql dans votre sql (import phpmyadmin)

```bash 
Import phpmyadmin

OU 

mysql -u votre_utilisateur -p votre_base_de_donnees < tomtroc.sql

````
## DEPLOIEMENT

Modifier le fichier config/config.php 

```bash
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'tomtroc');
    define('DB_USER', 'root');
    define('DB_PASS', ''); 
```
Compte de test 
```
email : inscription@inscription.com
password : inscription
```

## Authors

- [@Neeemos](https://github.com/Neeemos)


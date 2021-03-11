# Description

Code expliqué lors des visios sur Symfony.

# Installation

## Cloner le projet

`git clone https://github.com/webew/symfony5-demo-dwwm.git`

## Installer les dépendances

`cd symfony5-demo-dwwm`

`composer install`

## Configurer la base de données

> Créer un fichier _.env.local_ à la racine du projet

> Insérer dans ce fichier la ligne suivante :

> DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"

En remplaçant _dbuser_, _dbpassword_ et _dbname_ par vos valeurs.

Il se peut que vous ayez à modifier la fin de la ligne (?serverVersion=5.7) si vous êtes sous MariaDb. ;)

## Créer la base de données

`symfony console d:d:c`

## Créer les tables dans la base de données (migrations)

`symfony console d:m:m`

## Intégrer les données de test (fixtures)

`symfony console d:f:l`

## Lancer l'application

`symfony serve`

## Page d'accueil

http://localhost:8000/main

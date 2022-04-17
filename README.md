# projet-cocktails-party

Veuillez trouver ci-dessous le lien vers notre outil de gestion de sprints (GitHub Project):
  https://github.com/SakinaAnv/projet-cocktails-party/projects/1

Prérequi
*Prérequis sur votre machine pour le bon fonctionnement de ce projet :

PHP Version 8 Installer PHP -- Mettre à jour PHP en 7.4 (Ubuntu)
MySQL Installer MySQL ou Installer MariaDB
Symfony version 6.0 avec le CLI(Binaire) Symfony Installer Symfony -- Installer Binaire Symfony

Installation
Après avoir cloné le projet avec git clone https://github.com/SakinaAnv/projet-cocktails-party.git

Ensuite, dans l'ordre taper les commandes dans votre terminal :

1) composer install : afin d'installer toutes les dépendances composer du projet.

2) npm install : afin d'installer toutes les dépendances npm du projet.

3) yarn install : afin d'installer toutes les dépendances yarn du projet.

4) installer la base de donnée MySQL. Pour paramétrer la création de votre base de donnée, rdv dans le fichier .env du projet, et modifier la variable d'environnement selon vos paramètres :

DATABASE_URL=mysql://User:Password@127.0.0.1:3306/nameDatabasse?serverVersion=5.7
MAILER_DSN=gmail://Votre_adresse_mail:Votre_mot_de_passe@default?verify_peer=0

Puis exécuter la création de la base de donnée avec la commande : symfony console doctrine:database:create

5) Exécuter la migration en base de donnée : symfony console doctrine:migration:migrate

6) Exécuter les dataFixtures avec la commande : php bin/console doctrine:fixtures:load

7) Voir avant le css avant compilation : yarn run encore production --watch

8) Vous pouvez maintenant accéder à notre site en vous connectant au serveur : symfony server:start

9)Exécuter la commande git checkout fix pour vous rendre dans le dossier depuis le terminal.

Démarrage
Une fois sur l'application, il ne vous reste plus qu'à vous connecter ou bien à vous inscrire pour accéder à la partie cliente:
Login et mot de passe pour se connecter: 
Nom d’utilisateur : client1@gmail.com
Mot de Passe : ``client1`


Et pour accéder à la partie administration, vous devez vous connecter en fonction de votre role:
- Si vous êtes l'administrateur, 
Nom d’utilisateur : admin1@gmail.com
Mot de Passe : ``admin1`

-Si vous êtes un barman:
Nom d’utilisateur : staff1@gmail.com
Mot de Passe : ``staff`

-Si vous êtes un client du bar:
Nom d’utilisateur : client1@gmail.com
Mot de Passe : ``client1`

Projet développé avec:

Symfony - Framework PHP Symfony Latest Stable Release: 6.1.5
Bundle utilisé dans le projet :

Webpack encore
DomPdf Documentation DomPdf
Symfony google Mailer Documentation Symfony google Mailer
DoctrineFixturesBundle Documentation DoctrineFixturesBundle
Versions

Auteurs
Marième Soda SOW 
Sakina ANVARALY
Eric HAN 

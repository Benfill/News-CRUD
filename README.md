# Projet Laravel - API REST pour gérer des news

## Auteur
- Nom : Benfillous Anass
- Email : [Benfianass@gmail.com](mailto:Benfianass@gmail.com)
- Repository : [Test technique : CRUD de News en Laravel](https://github.com/Benfill/News-CRUD)

## Description du Projet
Ce projet consiste en une API REST utilisant Laravel 10 pour gérer des news. Les fonctionnalités incluent l'ajout, la suppression, la mise à jour et la consultation des news. L'API propose également des routes pour afficher une liste de news dans l'ordre décroissant de leur date de publication, sans inclure celles qui ont expiré. De plus, un algorithme de recherche récursif permet de trouver des news associées à des catégories spécifiques, y compris dans les sous-catégories.

## Configuration
Pour configurer le projet, suivez les étapes suivantes :

1. Cloner le projet sur votre machine locale.
2. Accédez au répertoire du projet via la ligne de commande.
3. Installez les dépendances avec `composer install`.
4. Configurez le fichier `.env` avec vos paramètres de base de données.
5. Exécutez les migrations avec `php artisan migrate`.
6. Remplissez les tables de catégories avec `php artisan db:seed --class=CategoriesSeeder`.
7. Ajoutez un utilisateur administrateur avec `php artisan db:seed --class=AdminSeeder`.
8. Générez des clés pour Laravel Passport avec `php artisan passport:keys`.
9. Créez un client personnel pour l'authentification avec `php artisan passport:client --personal`.

## Lancement de l'Application
Une fois la configuration terminée, vous pouvez lancer l'application en utilisant la commande suivante :
- `php artisan serve`

Cela démarrera le serveur local de Laravel. Vous pouvez ensuite utiliser des outils comme Postman pour tester l'API.

## Instructions de Test
Pour tester l'API, vous pouvez utiliser Postman ou des outils similaires. Voici quelques opérations à essayer :

Voici une version corrigée de la section "Authentification" et des opérations liées aux "News" et aux "Catégories" pour votre API :

### Authentification
- **POST /api/v1/login** : Permet aux utilisateurs de se connecter. Fournissez les identifiants nécessaires (par exemple, email et mot de passe) dans le corps de la requête.
- **POST /api/v1/register** : Permet aux utilisateurs de s'enregistrer. Fournissez les informations d'inscription requises.
- **POST /api/v1/logout** : Permet aux utilisateurs connectés de se déconnecter. Cette route doit être utilisée avec un token d'authentification valide.

### News
- **GET /api/v1/news** : Récupère la liste des news dans l'ordre décroissant de publication. Les news dont la date d'expiration est passée ne sont pas incluses.
- **POST /api/v1/news** : Ajoute une nouvelle news. Les données requises, comme le titre, le contenu, la catégorie, la date de début et la date d'expiration, doivent être fournies.
- **PUT /api/v1/news/{id}** : Met à jour une news existante par son identifiant. Fournissez les données à mettre à jour dans le corps de la requête.
- **DELETE /api/v1/news/{id}** : Supprime une news par son identifiant.

### Catégories
- **GET /api/v1/category/{categoryName}** : Récupère toutes les news associées à une catégorie donnée par son nom, y compris celles des sous-catégories. Seules les news non expirées sont affichées.

## Limitations et Assumptions
- Le projet nécessite une configuration de base de données adéquate.
- Le middleware d'authentification est utilisé, donc seuls les utilisateurs authentifiés peuvent accéder aux routes de l'API.


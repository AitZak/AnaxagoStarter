# Outils
* [Symfony5](https://symfony.com/4)

# Pour commencer

Pour lancer le projet vous aurez besoin de 
* [Apache](http://httpd.apache.org/docs/2.4/fr/install.html) >= 2
* [MySql](https://dev.mysql.com/doc/mysql-installation-excerpt/5.7/en/) >= 5.7
* [Php](https://www.php.net/manual/fr/install.php) >= 7.2

 [Aide Linux](https://www.digitalocean.com/community/tutorials/comment-installer-la-pile-linux-apache-mysql-php-lamp-sur-un-serveur-ubuntu-18-04-fr)
  ou [Aide Mac](https://documentation.mamp.info/en/MAMP-Mac/Installation/) 
  
# Lancer le projet sur Linux ou Mac

#### :warning: Créer son fichier .env.local a partir des informations manquantes Sinon la commande suivante ne pourra fonctionner!

```
make start-project
```

# Effacer le host

```
make clear start-project
```

# Lancer le projet sur Windows

### Prérequis

De quoi avez-vous besoin pour installer le logiciel et comment l'installer ?
- [Docker CE](https://www.docker.com/community-edition)
- [Docker Compose](https://docs.docker.com/compose/install)

### Initialisation du projet

```bash
cp .env.dist .env
docker-compose up -d
docker-compose exec web composer install
docker-compose exec web php bin/console d:s:u --force 
docker-compose exec web php bin/console d:f:l 
Write in .env: MAILER_URL=smtp://mailhog:1025
```
### Fonctionnalités

- Web: http://localhost
- phpMyAdmin: http://localhost:8080
- MailHog: http://localhost:8025

Pour tester l'API, rendez vous sur Postman ou équivalent. 
Vous pourrez :

- lister les projets avec leur statut d'avancement (“financé”,
  “non-financé”):
    > ``GET`` http://localhost/api/anonymous/projects
  
- un utilisateur inscrit peux enregistrer une marque d'intérêt en précisant le montant qu’il
  souhaite investir:
    > ``POST`` http://localhost/api/interest  
          exemple de JSON a envoyé dans le body de la requete, le montant de l'investissement en integer pour amountInvested et le slug du projet que l'on souhaite financer                                                                                                                                                                                                                     
  ``{
        "amountInvested": 800,
        "project": {
            "slug": "eole"
        }
    }``
- un utilisateur inscrit peux lister les projets sur lesquels il a marqué un intérêt:
    > ``GET`` http://localhost/api/interest

Pour les deux dernières fonctionnalités vous devez vous identifier via le header de la requête et le token d'authentification:
<br> Key :'X-AUTH-TOKEN'
<br> Value : *valeur du champ apiKey dans la table User en  BDD*
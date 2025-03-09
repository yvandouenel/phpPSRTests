# Installation
se placer dans le répertoire contenant index.php et lancer
```bash
composer install
```
# Exécuter le code 
se placer dans le répertoire contenant index.php et lancer 
  ```bash php -S localhost:3000```

# Explications
Cet exemple a pour but de montrer :
 - comment on peut récupérer les données issues d'une requête HTTP via GuzzleHttp
 - Renvoyer des infos sur la requette HTTP, en l'occurence 
  - Scheme (protocole)
  - Host (domaine)
  - Port
  - Path
  - QueryString
  - Fragment (ancre) 
 - les infos sont renvoyées en faisant un echo du body de $response. $response est une instance de use GuzzleHttp\Psr7\Response qui est retournée par la méthode handleRequest()
# Tests
A tester avec diverses url. Ex :
``http://localhost:3000/chemin?name=toto#chap1``
ou 
``curl -v http://localhost:3000/`` -v pour verbose pour donner un maximum d'informations notamment sur le header

Attention, les résultats peuvent être différents en fonction de votre OS et de la version de php. Cf [https://www.php.net/manual/fr/features.commandline.webserver.php] 

# Remarques 
Cette approche :
 - Encapsule la logique d'envoi de réponse
 - Gère proprement les headers et le status code
 - Se rapproche conceptuellement de l'approche Node.js et c'est l'approche adoptée par plusieurs frameworks PHP modernes comme Slim ou Laminas (ex-Zend).

 # Middleware
Dans cette version, nous ajoutons un middleware d'authentification selon le principe des middlewares PSR-15 (PHP Standard Recommendation).
Les middlewares PSR en PHP (PSR-15) sont des composants logiciels qui traitent les requêtes HTTP et les réponses de manière séquentielle. Chaque middleware peut :

- Examiner/modifier la requête entrante
- Examiner/modifier la réponse sortante
- Passer l'exécution au middleware suivant

Le mécanisme "next" est fondamental : chaque middleware reçoit un callable $next qu'il peut invoquer pour passer le contrôle au middleware suivant dans la chaîne. Si un middleware n'appelle pas $next, le traitement s'arrête.
Cette architecture permet de créer des `pipelines` de traitement modulaires pour l'authentification, la journalisation, la compression, etc.

Pour cela nous allons : 
- Créer  un dossier Middleware 
- Créez une interface pour standardiser les middlewares - cf src/Middleware/MiddlewareInterface.php
- Créez un middleware d'authentification - cf src/Middleware/AuthMiddleware.php
- Créez un gestionnaire de middleware pour exécuter une chaîne de middlewares - cf src/Middleware/MiddlewareHandler.php
- Modifier le fichier `src/Middleware/Router.php` pour y ajouter la gestion des middlewares
- Modifier le fichier `src/Middleware/Route.php` pour y ajouter la gestion des middlewares
- Modifier le fichier `index.php` pour y ajouter l'utilisation des middlewares et démarrer une session PHP pour permettre l'authentification basée sur session.

Le flux d'exécution est le suivant :

- Une requête arrive à index.php
- Le router trouve la route correspondante avec ses middlewares
- Le MiddlewareHandler est configuré avec tous les middlewares (globaux + spécifiques)
- Les middlewares sont exécutés en chaîne, dans l'ordre
- Si un middleware renvoie une réponse (ex: erreur 401), la chaîne est interrompue
- Sinon, le contrôleur final est exécuté

Pour compléter l'authentification, nous devrons :

- Mettre en place votre système d'authentification (session, JWT, etc.)
- Implémenter correctement la méthode isAuthenticated() dans AuthMiddleware
- Créer des contrôleurs et vues pour la connexion/inscription

Cette architecture est flexible et nous permet d'ajouter facilement d'autres types de middlewares selon les besoins.

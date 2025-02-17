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

A tester avec diverses url. Ex :
``http://localhost:3002/chemin?name=toto#chap1``

Attention, les résultats peuvent être différents en fonction de votre OS et de la version de php. Cf [https://www.php.net/manual/fr/features.commandline.webserver.php] 

# Remarques 
Cet exemple montre bien une des singularités du php. En effet, on voit ici qu'il suffit de faire un "echo" pour envoyer une réponse HTTP. Cette façon de faire n'est pas très explicite et ne sera pas utilisée par la pluspart des framework php. Nous verrons dans un exemple suivant comment on pourrait s'y prendre.
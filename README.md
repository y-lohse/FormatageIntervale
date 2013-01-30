# Afficher une date PHP en français, c'est chiant...

Je veux dire autre chose qu'un format type 21/12/2012. Un format avec des mots, des noms de mois, tout ca.

Et je parle même pas d'un intervale de temps, encore plus chiant.

# ....mais plus maintenant.

Ce repo contiens une fonction (packagée sous différente formes) qui gère tout ca pour vous.
Vous lui passez les dates en paramètre, il renvois une chaine de caractère bien française, bien propre.

Et en plus, c'est configurable.

##Fichiers

[standalone.php](https://github.com/y-lohse/FormatageIntervale/blob/master/standalone.php) contiens la 
fonction toute seule, que l'on peut inclure dans n'importe quel projet sans la moindre dépendance.

[FormatageIntervaleHelper.php](https://github.com/y-lohse/FormatageIntervale/blob/master/FormatageIntervaleHelper.php) 
fais la même chose mais est packagé sous forme d'un helper pour CakePHP.

## Prérequis

Compatible PHP 5.2 et plus. Les dates doivent être passés en tant qu'objets 
[DateTime](http://fr2.php.net/manual/fr/book.datetime.php).

# Utilisation

## Cas de figure gérés (a peuprès tous)

C'est simple, on passe en paramètres une ou 2 dates, et la fonction vous renvois une chaîne de 
caractères propre.

```php
$debut = new DateTime();
$debut->setDate(2012, 12, 21);

echo formatage($debut); //affiche "Le 21 Décembre"
```

La fonction gère aussi des dates et heure différentes

```php
//Jours différents
$debut = new DateTime();
$debut->setDate(2012, 12, 21);
$fin = new DateTime();
$fin->setDate(2012, 12, 22);

echo formatage($debut, $fin); //affiche "Du 21 Décembre au 22 Décembre"
```

```php
//Heures différentes
$debut = new DateTime();
$debut->setDate(2012, 12, 21);
$debut->setTime(20, 0, 0);
$fin = new DateTime();
$fin->setDate(2012, 12, 21);
$fin->setTime(21, 0, 0);

echo formatage($debut, $fin); //affiche "Le 21 Décembre de 20h00 à 21h00"
```

Et grosso-modo, tous les cas de figures sont gérés proprement.

## Configuration

Selon le fichier que vous prenez, la configuration ne se fais pas de la meêm façon mais les noms 
restent identiques. Ici l'exemple se base sur standalone.php mais le principe est le même pour tous.

### Configurer les options

La fonction peut prendre un 3ème paramètre sous forme de tableau avec des options dedans. 
En gros, comme ca :

```php
$debut = new DateTime();
$debut->setDate(2012, 12, 21);
$options = array('monOption'=>'maValeur');

echo formatage($debut, $debut, $options); //affiche "Le 21 Décembre"
```

### Format des dates et des heures

Les dates et les heures se formattent en utilisant les options habituelles de la fonction 
[date()](http://fr2.php.net/manual/fr/function.date.php).

Par défaut, les dates sont formattés selon le schéma __j F__ et les heures selon le format
__H\hi__. Ce qui donne respectivement des choses comme __21 Décembre__ et __21h00__. Vous remarquerez
que pour le nom du mois, on a utilisé le caractère __F__, qui en temps normal affiche le mois en anglais.
La fonction s'occupe de traduire les mois et les jours pour vous.

Ces 2 options peuvent être changés avec les paramètres __formatDate__ et __formatHeure__.

```php
$debut = new DateTime();
$debut->setDate(2012, 12, 21);
$options= array('formatDate'=>'l j F');

echo formatage($debut, $debut, $options);//Le Vendredi 21 Décembre
```

Le fonctionnement pour le format de l'heure est identique.

Par défaut, si les 2 dates ont exactement le même tronçon d'heure (ie. même heure, minute, seconde, etc)
la partie heure ne sera pas affichée, seulement la date.

```php
$debut = new DateTime();
$debut->setDate(2012, 12, 21);
$debut->setTime(20, 0, 0);
$fin = new DateTime();
$fin->setDate(2012, 12, 22);
$fin->setTime(20, 0, 0);

include 'standalone.php';
echo formatage($debut, $fin);//Affiche Du 21 Décembre au 22 Décembre
```

Vous pouvez forcer l'affichage de l'heure avec l'option __forceHeures__ :

```php
$debut = new DateTime();
$debut->setDate(2012, 12, 21);
$debut->setTime(20, 0, 0);
$fin = new DateTime();
$fin->setDate(2012, 12, 22);
$fin->setTime(20, 0, 0);

include 'standalone.php';
$options= array('forceHeures'=>true);
echo formatage($debut, $fin, $options);//Affiche Du 21 Décembre au 22 Décembre à 20h00
```

### Gérer les mots de liaison

Les mots utilisés pour faire des liaisons ( __Du__ ... __au__ ...) sont configurables aussi.
Il y a 4 options différentes :

- __uniqueDate__ affiche une date unique. Par défaut, cette option veux __Le %s__. %s est remplacé par 
la date en question.
- __uniqueHeure__ affiche une heure seule. Par défaut, cette option veux __à %s__.
- __intervaleDate__ : affiche un intervale de date. Par défaut, cette option veux __Du %1$s au %2$s__.
- __intervaleHeure__ : affiche un intervale de temps. Par défaut, cette option veux __de %1$s à %2$s__.

La logique est la même à chaque fous, on ne met que les mots de liaison et des jetons qui seront remplacés
par les dates et les heures. Un exemple pour la forme :

```php
$debut = new DateTime();
$debut->setDate(2012, 12, 21);
$options= array('uniqueDate'=>'A partir du %s');

echo formatage($debut, $debut, $options);//A partir du 21 Décembre
```

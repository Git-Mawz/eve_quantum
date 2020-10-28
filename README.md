# Eve Quantum

Liens vers l'application [Eve Quantum](https://eve-quantum.fr)

## Génèse

Eve Quantum est né de ma passion pour le MMORPG Eve Online et de mes connaissances acquisent lors d'une formation de developpement web de 5 mois débuté en janvier 2020.
L'idée de ce projet m'a servi de fil rouge au long de la formation et m'a donné des objectifs personnels dépassant les objectifs de la formation.
Une fois la formation terminée, j'ai commencé le developpement de Eve Quantum en août, en marge de ma recherche d'emploi et du travail sur un projet profesionnel.

## Technologies

Pour la partie back-end, Symfony 5 est utilisé suivant le design pattern MVC, avec twig en complément comme moteur de templating.
Symfony est également utilisé comme API Rest pour les parties dynamiques de l'application, qui elles, sont en JS vanilla.

Eve Online propose aux developpeurs une API Rest très complète (Eve Swagger Interface ou ESI) permettant aux utilisateurs connectés de pouvoir consulter les informations concernant leur personnage, mais également pouvoir les modifier sans être directement connecté au jeu.
La connexion à cette API s'effectué via le protocale OAuth 2.0.
Un de mes challenges personnels à été d'intégrer la connexion OAuth de l'ESI au composant Security de Symfony.

Lorsque l'utilisateur arrive sur Eve Quantum, il est invité à se connecter afin de profiter de plus de fonctionnalités.
Lorsqu'il se connecte, il est redirigé vers le site officiel Eve Online, où une interface lui demande son nom d'utilisateur et son mot de passe de jeu. Il est également averti des scopes de l'API qui sont necessaires à l'application pour fonctionner.
Enfin, à la connexion il est redirigé vers Eve Quantum et également authentifié par le composant Security de Symfony comme utilisateur avec un rôle et des droits au seins de l'application.

A titre d'exemple de fonctionnalité utilisant l'ESI : actuellement un utilisateur peut rechercher le nom d'un système solaire et définir sa destination in-game en utilisant l'interface de Eve Quantum.

Concernant la partie administration, j'ai souhaité la séparer du reste du site à l'aide d'une autre authentification n'étant pas dépendante de la connexion OAuth à Eve Online.
Toute la modération est disponible dans cette interface d'administration:
De l'édition de contenu au banissement temporaire ou définitif des membres qui n'auraient pas respecté les règles de l'application.

## Dépendances

* API :
  * [Eve Swagger Interface](https://esi.evetech.net/ui/)
* Connexion OAuth :
  * [php league oauth2 client](https://oauth2-client.thephpleague.com/)
  * [oauth2-eve client](https://github.com/killmails/oauth2-eve)
* Administration :
  * [EasyAdmin 3](https://symfony.com/doc/current/bundles/EasyAdminBundle/index.html)
* Options de mise en page des input textarea :
  * [FOSCKEditorBundle](https://symfony.com/doc/current/bundles/FOSCKEditorBundle/index.html)
* CSS :
  * [Bootstrap 4 / Bootswatch](https://bootswatch.com/slate/)

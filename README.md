Feuille de route
==============

- création d'un nouveau projet Symfony avec Composer
- création d'une nouvelle base de données sur phpMyAdmin
- création d'un nouveau bundle
- mise en place de la structure Twig (base, layout, page)
- compte utilisateur
    - route Yaml
    - contrôleur
        - manager/repository
        - rendu de vue
        - redirection
    - vue Twig
    - création entité User
        - annotations Doctrine
        - implémentation de l'interface UserInterface
        - UUID
        - entrée unique dans la BDD
        - salage
        - règles de validation        
        - constructeur 
    - formulaire
        - ajout des différents types de champs
        - validation
        - cascade     
    - sécurité
        - encryptage bcrypt 
        - fournisseur
        - hiérarchie des rôles
        - firewall
        - contrôle d'accès
    - login
        - dernier utilisateur
        - gestion d'erreur
        - CSRF
        - connexion auto après création de compte
- message flash
- Chat en AJAX
    - utilisation de jQuery
    - liste et ajout de messages
        - entité Message avec relation many to one
    - liste des utilisateurs actifs
        - utilisation du query builder
        - dernière activité
            - création d'un listener dans les services
- envoi sur Github            
- déploiement du site




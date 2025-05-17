# Gestionnaire de Tâches

Une application web simple et efficace pour gérer vos tâches quotidiennes.

## Description

Ce projet est un gestionnaire de tâches développé en PHP qui permet aux utilisateurs de :
- Créer de nouvelles tâches
- Modifier les tâches existantes
- Supprimer des tâches
- Mettre à jour le statut des tâches
- Visualiser toutes les tâches dans une interface intuitive

## Prérequis

- PHP 7.0 ou supérieur
- MySQL/MariaDB
- Serveur web (Apache recommandé)
- XAMPP (recommandé pour le développement local)

## Installation

1. Clonez ce dépôt dans votre répertoire web (par exemple, dans le dossier `htdocs` de XAMPP)
2. Importez la base de données (le fichier SQL sera fourni)
3. Configurez les paramètres de connexion à la base de données dans `db.php`
4. Accédez à l'application via votre navigateur web

## Structure du Projet

- `index.php` - Page principale affichant la liste des tâches
- `formulaire.php` - Formulaire de création de nouvelles tâches
- `modifier.php` - Interface de modification des tâches
- `supprimer.php` - Script de suppression des tâches
- `update_status.php` - Script de mise à jour du statut des tâches
- `db.php` - Configuration de la connexion à la base de données
- `style.css` - Styles CSS de l'application

## Fonctionnalités

- Interface utilisateur intuitive et responsive
- Gestion complète des tâches (CRUD)
- Suivi du statut des tâches
- Design moderne et épuré

## Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## Contact

Pour toute question ou suggestion, n'hésitez pas à ouvrir une issue dans le dépôt. 
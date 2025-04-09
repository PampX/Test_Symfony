# 📝 Mini CMS Symfony

Petit projet d’introduction à **Symfony** côté front, sans base de données, pour créer, lister et consulter des articles, avec persistance dans un fichier JSON.

---

## 🚀 Fonctionnalités

- Accueil avec navigation simple
- Liste des articles
- Création d’un nouvel article via un formulaire
- Visualisation individuelle d’un article
- Persistance des articles dans un fichier `var/articles.json` (pas besoin de base de données !)

---

## 🛠️ Techs utilisées

- [Symfony](https://symfony.com/)
- Twig pour le rendu des templates
- Fichier JSON comme pseudo-base de données

---

## ⚙️ Installation

```bash
# Cloner le projet
git clone https://github.com/ton-user/mini-cms-symfony.git
cd mini-cms-symfony

# Installer les dépendances
composer install

# Lancer le serveur local
symfony serve

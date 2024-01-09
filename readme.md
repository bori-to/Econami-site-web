# Econami-site-web
Création d'un site WEB pour le projet annuel de l'école ESGI

Construire et configurer un site Web dynamique. Une programmation WEB dynamique "from scratch" Réalisation d'un back-office et front-office complet Base de données avec MariaDB Utilisation d'un VPS OVH Création de captcha, utilisation de PHPMailer, Api fetch javascript, etc ...

Econami c'est quoi ?
Un site WEB de Ventes et Achats de Coupon de Réduction.
Avec un Forum, un espace VIP, des ventes privée, un système de points, etc... 

![Logo Econami](src/images/econami2.png)


## 📜 Prérequis

Installer un serveur LAMP (Linux, Apache, MySQL/MariaDB, PHP) :

- Avoir les extensions PHP suivante :
```bash
php-mysql php-pdo php-gd php-curl php-json php-mbstring php-xml php-zip php-openssl php-intl
```
- Créer la BDD "econami" à l'aide du fichier dump.sql

## 🚀 Installation
1. Cloner le dépôt GitHub :
```bash
git clone https://github.com/bori-to/Econami-site-web.git
```
2. Accéder au répertoire du projet :
```bash
cd Econami-site-web
```
3. Éditer les fichiers suivant:  
- les paramètres BDD include/db.php
- l'email dans include/email.php, abs_users.php, mail.php, vente_verif.php
- la config stripe dans paiement/config.php

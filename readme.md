# Econami-site-web
![GitHub Repo stars](https://img.shields.io/github/stars/bori-to/Econami-site-web)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Creation of a WEB site for the annual project of the ESGI school

Build and configure a dynamic website. Dynamic WEB programming "from scratch", Creation of a complete back-office and front-office, Database with MariaDB, Use of an OVH VPS, Creation of captcha, use of PHPMailer, Api fetch javascript, bootstrap etc. ..

What is Econami?
A Discount Coupon Sales and Purchases WEBSITE.
With a Forum, a VIP area, private sales, a points system, etc...

![Logo Econami](src/images/econami2.png)


## 📜 Previously

Install a LAMP server (Linux, Apache, MySQL/MariaDB, PHP):

- Have the following PHP extensions:
```bash
php-mysql php-pdo php-gd php-curl php-json php-mbstring php-xml php-zip php-openssl php-intl
```
- Create the "econami" database using the `dump.sql` file

## 🚀 Installation
1. Clone the GitHub repository:
```bash
git clone https://github.com/bori-to/Econami-site-web.git
```
2. Access the project directory:
```bash
cd Econami-site-web
```
3. Edit the following files:
- BDD parameters `include/db.php`
- the email in `include/email.php`, `abs_users.php`, `mail.php`, `vente_verif.php`
- the stripe config in `payment/config.php`

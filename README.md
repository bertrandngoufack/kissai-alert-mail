Kissai Alert - CPaaS (CodeIgniter 4, Bulma, MariaDB)

Overview
Kissai Alert est une plate-forme CPaaS multicanal bâtie sur CodeIgniter 4. Elle fournit des APIs OTP (2FA) et Email Marketing. Chaque client utilise son propre SMTP. La documentation Swagger/OpenAPI est incluse.

Stack
- PHP 8.1+
- CodeIgniter 4.x
- MariaDB 10.5+
- Bulma 1.x (UI admin)
- Swagger UI (daycry/swagger)

Installation rapide
1) Pré-requis: PHP 8.1+, Composer, MariaDB.
2) Dans ce dossier, exécutez:
   composer install
3) Copiez le fichier d'environnement et générez la clé:
   cp env .env
   php spark key:generate
4) Configurez votre base dans .env (section database.default.*).
5) Appliquez les migrations et seed:
   php spark migrate
   php spark db:seed AdminSeeder
6) Lancez le serveur de développement:
   php spark serve

Swagger
- Générer/Publier la configuration Swagger (si nécessaire):
  php spark swagger:publish
- Accéder à l'UI: /swagger

Routes API exposées
- POST /api/rest/otp/generate
- POST /api/rest/otp/check
- POST /api/rest/email/send

Authentification API
- Passez la clé API dans l'en-tête Authorization:
  Authorization: Basic VOTRE_CLE_API
  ou
  Authorization: Bearer VOTRE_CLE_API

Configuration SMTP par client
- Dans la table `users`, les champs smtp_* définissent le serveur du client utilisé par l'API email.

Bulma (UI Admin)
- Ajoutez Bulma dans votre layout: https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css

Notes
- Les fichiers de ce dépôt ajoutent la logique métier (migrations, modèles, contrôleurs, filtres). Ils reposent sur le squelette CodeIgniter 4 standard fourni par Composer.


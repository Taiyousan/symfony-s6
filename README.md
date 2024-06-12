1. Installer le dépôt git
    - aller dans /pdf-webapp

2. Installer les dépendances symfony : 
    ```bash
    composer install
    ```

3. Créer la base de données : 
    ```bash
    php bin/console doctrine:database:create
    ```

4. Créer les tables : 
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

5. Charger les données de test : 
    ```bash
    php bin/console doctrine:fixtures:load
    ```

6. Lancer le serveur : 
    ```bash
    symfony server:start
    ```

7. Aller sur /pdf-service

8. Installer les dépendances symfony : 
    ```bash
    composer install
    ```

9. Lancer le serveur : 
    ```bash
    symfony server:start
    ```

# La Boot'ique :handbag: :dress: :high_heel:

## The website :computer:

Simple Ecommerce with extern payment method. I made this website mainly to learn how to use a payment API, Easy Admin, and a mailer. Any user can suscribe, and then purchase any products. Of course, this is a test version of Strip, you can't really use your card. But still, a validation will be set, and you'll receive a confirmation mail. If you use the contact section, I will reveive an email from the website.

![image info](./bootique.png)

![image info](./bootique2.png)

![image info](./bootique3.png)

## Back Office :package:

As an admin (role = "ROLE_ADMIN"), we can add products, modify banners, top products, handle users, carriers, categories and orders.

![image info](./backoffice.png)
![image info](./backoffice2.png)

## Stack :wrench:

- Symfony 5.4
- Easy Admin
- Twig
- Bootstrap
- Stripe
- Mailjet

## How to install project :hammer:

- After cloning the repo, run :
  
    ```bash
    composer install
    ```

- Import the database from file e-commerce.sql
- Specify your work environment :

    ```bash
    DATABASE_URL="mysql://user_name:password@127.0.0.1:3306/database_name?serverVersion=mariadb-10.3.25"
    APP_ENV=dev
    ```

- If needed, clear cache :

    ```bash
    php bin/console cache:clear
    ```

# Small E-commerce Management

A small e-commerce management system built for the CSN Bangladesh technical assessment.

Administrators manage shops, products and shop owner accounts. Shop owners pick products from a shared catalog (or create their own) and list them in their shop with their own price, title, details and thumbnail. Customers browse shops and see only products that are listed in a shop.

**Stack:** Laravel, Inertia.js with Vue 3, Tailwind CSS, MySQL.

## Requirements

- PHP 8.2 or higher (with the `pdo_mysql`, `mbstring`, `fileinfo` extensions)
- Composer
- Node.js 18 or higher and npm
- MySQL 5.7+ / 8+ (or MariaDB)

## Setup

1. Clone the repository and enter the folder:

    ```bash
    git clone https://github.com/skabuamer/csn-ecommerce-task.git
    cd csn-ecommerce-task
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Create the environment file and generate the app key:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Create an empty MySQL database named `csn_ecommerce`. Use any one of these:

    **Option A: MySQL command line**

    ```bash
    mysql -u root -p -e "CREATE DATABASE csn_ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    ```

    (Press Enter at the password prompt if your root user has no password.)

    **Option B: phpMyAdmin / MySQL Workbench / any GUI**

    Create a new database named `csn_ecommerce` with collation `utf8mb4_unicode_ci`.

5. Check the database settings in `.env`. The defaults are:

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=csn_ecommerce
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    Change `DB_USERNAME` and `DB_PASSWORD` if your MySQL setup is different.

6. Run the migrations and seeders:

    ```bash
    php artisan migrate --seed
    ```

7. Link the storage folder (needed so uploaded and seeded images are visible):

    ```bash
    php artisan storage:link
    ```

8. Install frontend dependencies and build the assets:

    ```bash
    npm install
    npm run build
    ```

9. Start the application:

    ```bash
    php artisan serve
    ```

    Open http://127.0.0.1:8000

For development with hot reload, run `npm run dev` in a second terminal instead of `npm run build`.

## Demo accounts

All demo accounts use the password `password`.

| Role       | Email              | Shop        |
| ---------- | ------------------ | ----------- |
| Admin      | admin@example.com  | -           |
| Shop owner | owner1@example.com | Tech Hub    |
| Shop owner | owner2@example.com | Home Corner |

Login page: http://127.0.0.1:8000/login

## Features

### Admin panel (`/admin`)

- Admin authentication
- Shop management (create, edit, delete)
- Product management (create, edit, delete, thumbnail upload)
- Create and manage shop owner accounts and assign each owner a shop

### Shop owner panel (`/owner`)

- Browse the shared product catalog (products created by the admin and by other owners)
- Add a catalog product to their own shop, optionally setting a custom price, title, details and thumbnail
- Create new products, which become available in the shared catalog and are listed in their shop automatically
- Edit or remove listings in their own shop only (an owner cannot touch another owner's shop)

### Customer view (`/`)

- Browse all shops and a combined product grid
- View a shop's products with the shop's own price, title, details and thumbnail
- Products that are not listed in any shop are never shown

## How it works

- `users.role` is either `admin` or `shop_owner`. Route groups are protected by the `auth` and `role:<name>` middleware.
- `products` is the shared catalog.
- `shop_products` links a shop to a product. Its `price` is the shop's price, and its optional `title`, `details` and `thumbnail` override the catalog product's values for that shop. When they are empty, the catalog values are used.
- The customer pages read from `shop_products` only, so a product without a listing cannot appear to customers.

## Notes

- Seeded data includes one product ("Unlisted Product") that is not in any shop. It appears in the admin panel and in the owner catalog, but not on any customer page.
- If images do not load, make sure `php artisan storage:link` was run.
- To reset everything: `php artisan migrate:fresh --seed`

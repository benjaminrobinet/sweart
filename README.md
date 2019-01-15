Base on Eloquent for a school project.
It is meant to re-implement an Active Record ORM

# Official Git Repository
[benjaminrobinet/sweart](https://github.com/benjaminrobinet/sweart)

# Install
## Initial setup
Install all the dependencies with composer using:
```bash
composer install
```

## Setup database
Import the `article.sql` file into your MySQL Database.

## Configure Sweart
Move the file in `config/configuration.ini.dist` to `config/configuration.ini`. And replace settings with your own environment configuration.

# Test
By default, there is a demo in the `index.php` which demonstrate how to get a **Categorie** and all the **Articles** of that **Category**
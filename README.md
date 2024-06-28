# php-user-management
A simple CRUD web project for user management.

## Requirements
```
- XAMPP (Apache and MySQL)
- PHP (version 7.0 or higher)
- Composer
```
Leave `XAMPP` up and running after its installation.

## Database
The database requires to be manually setup for this project.
- Access `phpMyAdmin` through `XAMPP` control panel and select the SQL tab.

- Copy the `ddl.sql` file located in the root of this project and paste it at the query box then click on `Execute`.

- Rename the `.env.example` file to `.env`, set your own values to the variables if required.

## Installation
Download the project by visiting the [releases page](https://github.com/PoweredTable/php-user-management/releases) of this repository and unzip the file, or you could also simply clone it.

To work with `XAMPP`, ensure the project will be located at `XAMPP` folder installation, e.g. `C:\xampp\htdocs`.

Inside the project folder, install the required dependencies using `Composer`.
```bash
composer install
```

## Usage
Access the web page through http://localhost/php-user-management.
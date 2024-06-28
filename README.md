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
The database needs to be manually set up for this project.
- Access `phpMyAdmin` through the `XAMPP` control panel and select the SQL tab.

- Copy the contents of the `ddl.sql` file located in the root of this project and paste it into the query box, then click on `Execute`.

- Rename the `.env.example` file to `.env` and set your own values for the variables if required.

## Installation
Download the project by visiting the [releases page](https://github.com/PoweredTable/php-user-management/releases) of this repository and unzip the file, or you could also simply clone it.

To work with `XAMPP`, ensure the project is located in the `XAMPP` installation folder, e.g. `C:\xampp\htdocs`.

Inside the project folder, install the required dependencies using `Composer`.
```bash
composer install
```

## Usage
Access the web page through http://localhost/php-user-management. You should see the homepage below if the installation was done correctly.

![](/docs/img/homepage.jpeg)

Click on the **NEW USER** button. A modal will appear asking for user data input.

![](/docs/img/user%20form.jpeg)

You must fill the form with the user **name**, **e-mail**, **phone** and a **photo**, which must be uploaded.

The **photo** must be a `.JPG`, `.JPEG` or `.PNG` file, other file extensions are not supported.

![](/docs/img/filled%20user%20form.jpeg)

After clicking on **Save changes** you'll see an HTML alert box displaying whether the request was successfull or not.

A successful request will refresh the page, and the newly added user will appear.

![](/docs/img/homepage%20with%20user.jpeg)

You can also update or delete the user shown on the homepage. Click on the yellow 'U' button to update or the red 'D' button to delete.

---

Made with 💜 &nbsp;by Lucas da Silveira 👋
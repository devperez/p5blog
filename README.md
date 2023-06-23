# Blogpro

Blogpro is my professional blog dedicated to web development. This project is part of my OpenClassRooms training to become a fully fledged web developer. This is my 5th project.
- Technologies :
  
  ![PHP Badge](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=fff&style=plastic) (mainly)

  ![JavaScript Badge](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=000&style=plastic) (a bit)

  ![Composer Badge](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=fff&style=plastic)

  No framework

## Installation

This is meant to be used with Apache.
First : clone the repository in your 'www' Apache folder.
If composer is not installed on your system, follow the instructions to install it here : [COMPOSER](https://getcomposer.org/doc/00-intro.md)
When you're done with the installing, go to the root folder of the project and install the dependencies:

```bash
composer install
```
### MailHog
In order to use the contact form and receive an email, there is on more step to go through : you have to install MailHog. MailHog will enable you to send mails locally.
- If you are using Ubuntu or a similar Linux distribution, follow these steps :
```bash
sudo apt-get -y install golang-go
sudo apt-get install git
go install github.com/mailhog/MailHog
```
Once installed, you can run it :
```bash
~/go/bin/MailHog
```
You can then reach your inbox following the address given by the script. Usually localhost:8025 or  127.0.0.1:8025.

- If you are using Windows you can go to the official github repository page of [MailHog](https://github.com/mailhog/MailHog/releases) and download the .exe file suitable for your system. Once downloaded, double-click on the file and it should install itself.

### Database
Open your PhpMyAdmin and import the .sql file which is in the root folder of the project. This should install the database with some articles, comments and users.

NOTES :
- The articles have been AI generated in order not to waste time and to provide something else than Lorem Ipsum texts.
- Only the admin can have access to the back office. All the user accounts have the same password which is 123456.

## Usage
Make sure Apache is running. Open your favourite browser and go to this address : http://blogpro/?url=home.
You can browse the blog freely. With MailHog running, you can complete the form and send an email.
If you want want to leave a comment, you can pick a registered account or create a new one.
Registered accounts :

 Login             | password 
:-----------------:|:--------:
 testmail@mail.com | 123456   
 test2@gmail.com   | 123456   
 test@gmail.com    | 123456   
 michel@gmail.com  | 123456  



If you want to access the back office, you'll have to login with the admin account.

 Login             | password 
:-----------------:|:--------:
 mail@gmail.com     | 123456   


Enjoy !

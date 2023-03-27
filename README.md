


## About Saraha App

Saraha is a website application gives the ability to each registered user to receive private messages

## How to run the app in your local machine
- Clone the project
- Run "composer update" in your terminal
- Create .env file
- Run 'php artisan key:genereate' in your terminal
- Create database in phpmyadmin and add it in your .env file
- Run "php artisan migrate:fresh --seed" in your terminal
- Use this credentials to access the app email: admin@saraha.com password: 12345678


## Features

- Every user has a public profile created automatically after registeration
- As a registered user, you can share your public profile with others to receive private messages
- You cannot know the sender of the message
- Admin has the ability to restore deleted messages or delete it forever!
- Admin has the ability to see all messages even the deleted ones
- Admin can assign any member as admin
- Admin has the ability to see all registred users in the website

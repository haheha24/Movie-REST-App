# Movie-REST-App

## A portfolio project to demonstrate a PHP REST application based on Movies. 

## Environment / Requirements
- Created on a XAMPP (Apache + MariaDB + PHP + Perl) for Windows 8.2.12
- PHP version 8.2.12
- Composer version 2.8.2
- Haven't tested on other versions with the current setup

## Installation
- Clone the repository or download manually
- In the root directory of the repo run `composer run-script setup` in a console
- Start apache server and mysql
    - Import emoviesdb.sql (located in server/migration diretory) into mysql
- Create a .env file in client and server directory each with the following variables:
    - client.env
        - SERVER_URI=http://localhost/server
        - CLIENT_URI=http://localhost/client
        - POSTER_PATH=static/assets/posters
    - server.env
        - DB_HOST=localhost
        - DB_NAME=emoviesdb
        - DB_USER=root
        - DB_PASS=''
- You will need to adjust the variables .env files depending on your setup if necessary.

## To do
- Add client side and server side validation
# WebProject Instructions

# mySql Setup
To create the SQL database structure, simply copy the following text into PHPmyAdmin SQL part and run it

---
```
CREATE DATABASE Interview;

CREATE TABLE `admin`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` CHAR(100) NOT NULL,
    `password` CHAR(100) NOT NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `candidate` 
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` CHAR(100) NOT NULL,
    `first_name` CHAR(50) NOT NULL,
    `last_name` CHAR(50) NOT NULL,
    `password` CHAR(100) NOT NULL,
    `hash` CHAR(100) NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `active` BIT NOT NULL DEFAULT 0,
PRIMARY KEY (`id`) 
);
```
---

THEN, when you have done that, you need to add one admin user into the admin TABLE
to do that, you will need to provide a hashed password. There is a tool for this off of the adminindex.html page
think of a password, and cut and past that directly into phpmyadmin password field, along with the username you choose
You will need to configure your mysql database first.

# sendmail
This project also requires setting up of fake **sendmail** on your system

sendmail.exe is a simple windows console application that emulates sendmail's
"-t" option to deliver emails piped via stdin.

it is intended to ease running unix code that has /usr/lib/sendmail hardcoded
as an email delivery means.

it doesn't support deferred delivery, and requires an smtp server to perform
the actual delivery of the messages.

## sendmail install
(1) download [sendmail.zip](http://www.glob.com.au/sendmail/sendmail.zip)

(2) copy sendmail.exe and sendmail.ini to C:\Bitnami\wampstack-7.1.15-0 on the drive where the
    unix application is installed.

(3) configure smtp server and default domain in sendmail.ini
```
smtp_server=smtp.gmail.com
smtp_port=465
smtp_ssl=ssl
default_domain=localhost
error_logfile=error.log
debug_logfile=debug.log
auth_username=youremailaddress@gmail.com
auth_password=the passsord google gave you.
```
To generate a password please look here:
https://security.google.com/settings/security/apppasswords
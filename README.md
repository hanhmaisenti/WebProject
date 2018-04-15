# WebProject Instructions
Firstly, to read the Yuml diagrams, you need to install the YUML extension in Visual Source code. Really good tool.
Its easy to obtain the diagrams: You copy the Yuml code and paste it into the following website:
https://yuml.me/diagram/scruffy/class/draw

# mySql Setup
To create the SQL database structure, simply copy the following text into PHPmyAdmin SQL part and run it

---
```
CREATE DATABASE Interview;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` char(100) NOT NULL,
  `password` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.com', '$2y$10$xbDqN0Cln0RtJwwp5lQ3mux.3IWWk2FUJwEH8Z.QqQhyQgyIZKWYi');
```

The default admin@admin.com administrator user password is password

```
CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `candidateid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `candidate` (
  `id` int(11) NOT NULL,
  `email` char(100) NOT NULL,
  `first_name` char(50) NOT NULL,
  `last_name` char(50) NOT NULL,
  `password` char(100) NOT NULL,
  `hash` char(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` bit(1) NOT NULL DEFAULT b'0',
  `questiontype` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `questiontype` text NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `candidate`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);
```
---

THEN, when you have done that, you need to add one admin user into the admin TABLE to allow administration!
to do that, you will need to provide a hashed password. There is a tool for this off of the adminindex.html page
think of a password, and cut and past that directly into phpmyadmin password field, along with the username you choose
You will need to configure your mysql database first.
```
INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, '<<YOUR EMAIL>>', '<<YOUR HASHED PASSWORD>>'),
```

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

## Links to your code on Windows
Github desktop maintains your code in a directory something like this: C:\Users\<<yourName>>\Documents\GitHub
To get all active changes to your webserver (like WAMPstack or MAMP etc) its useful to create symbolic links to your Git Code repositories within the htdocs directory of your webserver so changes you make will immediately be seen on the website.
to do this, you can research symbolic links on windows, or install [Link Shell Extension]http://schinagl.priv.at/nt/hardlinkshellext/linkshellextension.html

Then, go to your source directory (C:\Users\<<yourName>>\Documents\GitHub\whateveryyourprojectiscalled), right click and select "Pick Link Source"
Next, navigate to your C:\Bitnami\wampstack-7.1.15-0\apache2\htdocs directory, right click, and Drop as..Junction
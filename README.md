# Simple Registeration Form with PHP and MYSQL

## Installation

Install php >= 7.2
Install apahche2
Install MySQL

Clone the Repo

```
cd /var/www/html
git clone https://github.com/NourhanAymanElstohy/Simple-registeration-form.git
```

In MySQL

```
CREATE DATABASE webgen_task4;
CREATE TABLE users (id INT NOT NULL AUTO_INCREMENT, name VARCHAR(50), email VARCHAR(50), phone VARCHAR(50), address VARCHAR(150), password VARCHAR(50));
```

Edit DATABASE Credential

```
go to file conf.php and add your database credentials
```

Run The application, On Browser

```
http://localhost/Simple-registeration-form/index.php
```

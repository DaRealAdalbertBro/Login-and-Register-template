# Login-and-Register-template
A simple login and registration template that includes email verification, hashing and ID generation.

# Database set-up
First, you must log in as root to the mysql database itself.
```
mysql -u root
```

<br>

After logging in, create a user with the name `template_user` and the password `templatePassword`.
```
CREATE USER 'template_user'@'159.65.87.83' IDENTIFIED BY 'templatePassword';
```

<br>

Grant permissions to the account, using
```
GRANT ALL PRIVILEGES ON template TO 'template_user'@'159.65.87.83';
```

<br>

and flush all privileges.
```
FLUSH PRIVILEGES;
```

<br>

Then exit with `\q` command and log in to the new account you just created,

```
mysql -u template_user -p
```

<br>

And after all that, you can finally create a database called `template` (or whatever you want).

```
CREATE DATABASE template;
```

<br>

Then select the database with the `USE template;` command and create a table called `users`, exactly like this

```
CREATE TABLE IF NOT EXISTS users(
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    name varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    salt varchar(255) NOT NULL,
    hash varchar(255) NOT NULL,
    mail varchar(255) NOT NULL UNIQUE,
    PL SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    verification_code int UNSIGNED,
    verified SMALLINT UNSIGNED DEFAULT 0,
    PRIMARY KEY(user_id)
);
```

# Gallery

![image](https://user-images.githubusercontent.com/56306485/161125842-4058ea07-affe-482a-a64b-910c955bfbe1.png)

![image](https://user-images.githubusercontent.com/56306485/161125957-a1cda2b7-2091-4907-9ea2-a202ac0c516e.png)

![image](https://user-images.githubusercontent.com/56306485/161126035-e713cfa5-6794-4c60-85c0-3e3d2161bf9d.png)

![image](https://user-images.githubusercontent.com/56306485/161126260-b8f630cf-876a-4dc1-ae1a-2bb7ddc1dd1d.png)

![image](https://user-images.githubusercontent.com/56306485/161126651-9a6d56ba-ca6e-4a27-b599-b3225a7e180c.png)

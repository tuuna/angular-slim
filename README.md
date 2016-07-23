# Angular-Slim
- Angular AND Slim 3.0 to achive a single page web application

##Slim

- You may need to install **composer** first
- Then get the Slim framework in your vendor dir by **composer require slim/slim "^3.0"**

## Rewrite

To get rid of the index.php and achieve Pseudo-static,we can rewrite the conf of Apache or Nginx

### Apache

```

RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```

### Nginx
```
root        /path/to/path;

    location / {
        root    /path/to/path;
        index   index.html index.php;
        try_files $uri $uri/ /index.php?$args;
    }
```

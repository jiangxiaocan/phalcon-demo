#phalcon-demo
已经搭建好基础架，可以直接使用redis、elasticsearch、mysql等其他功能

## 版本要求
php>=7.0  
phalcon>=7  
Nginx
redis
mysql

## 命令
composer install 

## nginx配置


    server {
        listen      80;
        server_name local.phalcon.com;
        root        /www/phalcon-demo/public;
        index       index.php index.html index.htm;
        charset     utf-8;
        location / {
                     try_files $uri $uri/ /index.php?_url=$uri&$args;
                 }

    location ~ \.php$ {
        try_files     $uri =404;

        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index /index.php;

        include fastcgi_params;
        fastcgi_split_path_info       ^(.+\.php)(/.+)$;
        fastcgi_param PATH_INFO       $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

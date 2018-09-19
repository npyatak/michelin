Установка проекта:

1) Создать папку для сайта. /var/www/michelin, например
2) Прописать documentRoot в корень проекта для Apache. htaccess разведет бэкенд и фронт. 
Если сервер не поддерживает htaccess, то прописать documentRoot в frontend/web для фронт, в backend/web для админки
3) cd /var/www/michelin
4) git init
5) git pull https://github.com/npyatak/michelin master
6) php init (0 - developer, 1 - production для боевого сервера)
7) Установить composer - https://www.hostinger.com/tutorials/how-to-install-composer
Затем composer update. 
8) Создать базу данных и прописать ее в конфиге: /common/config/main-local.php
9) php yii migrate

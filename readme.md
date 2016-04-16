#Простой блог, основанный на PHP+MySQL#

##Основные моменты:##
- устанавливается через копирование файлов на удаленный сервер, и исполнение двух sql скриптов;
- для каждого поста указывается заголовок поста, сам пост, и автоматически устанавливается время добавления;
- добавление, редактирование, удаление, доступно только пользователю  "admin";
- комментария могут оставлять зарегистрированные пользователи, просмотр открыт для всех;
- поиск по постам;
- выдача постов по 5 на одной странице;

##Установка:##
- скачать репозиторий;
- скопировать содержимое репозитория на удаленный сервер;
- выполнить запросы из файла schema.sql для создания структуры базы данных и (опционально) sample.sql для наполнения блога содержанием;
- пользователь с правом создание/удаления постов по умолчанию "admin", пароль "123";


##Requirements##

- PHP 5.5+
- MySQL 5.0+

##Setup Database##


####Get copy of source code####
```
cd /var/www
git clone https://github.com/molchanovvg/myblog.git
```
####Run the script:####
```
1. schema.sql
2. sample_only_admin.sql or sample_full.sql
```
##Note##

User with right create/delete posts default is admin/123

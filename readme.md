#Простой блог, основанный на PHP+MySQL#
[Демо версия](http://myblog.molchanov.site)

[Readme ENG](https://github.com/molchanovvg/myblog/blob/master/readme.ENG.md)

##Основные моменты:##
- устанавливается через копирование файлов на удаленный сервер, и исполнение двух sql скриптов;
- для каждого поста указывается заголовок поста, сам пост, и автоматически устанавливается время добавления;
- добавление, редактирование, удаление, доступно только пользователю  "admin";
- комментария могут оставлять зарегистрированные пользователи, просмотр открыт для всех;
- поиск по постам;
- выдача постов по 5 на одной странице;

## Установка##

####Минимальные требования####
- PHP 5.5+
- MySQL 5.0+
- [Composer](https://getcomposer.org/download/)

####Скопировать репозиторий####
```
cd /var/www
git clone https://github.com/molchanovvg/myblog.git
php composer.phar install
```
#### Выполнить скрипты####
```
1. <project>/sql/schema.sql for create structures
2. <project>/sql/sample_only_admin.sql or <project>/sql/sample_full.sql for Blog content
```
#### Указать свои параметры####
```
<project>/params.php
```
#### Примечание####

Пользователь с правами добавления/удаления записей, по умолчанию: admin/123

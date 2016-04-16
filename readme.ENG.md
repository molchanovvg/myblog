# Simple blog, based on PHP and MySQL#
[Demo](http://myblog.molchanov.site)

[Readme RUS](https://github.com/molchanovvg/myblog/blob/master/readme.md)
##Basic moments:##
- Established after copying files to a remote server, and the execution of two sql scripts;
- For each post is indicated post title, post himself, and is automatically installed during the addition;
- Add, edit, delete, available only to the user "admin";
- Comment to post registered users, view open to all;
- Search for posts;
- Issuing posts to 5 on the same page;

## Setup##

####Requirements####
- PHP 5.5+
- MySQL 5.0+

####Get copy of source code####
```
cd /var/www
git clone https://github.com/molchanovvg/myblog.git
```
####Run the script:####
```
1. <project>/sql/schema.sql for create structures
2. <project>/sql/sample_only_admin.sql or <project>/sql/sample_full.sql for Blog content
```
####Note####

User with right create/delete posts default is admin/123

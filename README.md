SyMDWiki
================
SyMDWiki - Symfony Markdown Wiki is a small markdown-flavored wiki. 

#Features

- Markdown syntax
- Activity log
- Display order (higher ```sortid``` means higher priority)
- Public content section

#Installation

- Clone the repository ```git clone https://github.com/gehaxelt/PHP-SyMDWiki.git ```
- Install comphoser ```curl -sS https://getcomposer.org/installer | php```
- Create the database ```php app/console --env=prod doctrine:schema:create ```
- Update the database if necessary ``php app/console --env=prod doctrine:schema:update --force```
- Generate static assets: ```php app/console --env=prod assetic:dump```
- Install assets: ```php app/console --env=prod assets:install web```
- Make sure that the cache directory is writeable ```chmod -R +w app/cache/```
- Install dependencies ```php composer.phar install```
- Point your webserver to the /web directory ```DocumentRoot /var/www/SyMDWiki/web```
- Have fun!

#Screenshots

- Login area: ![Login area](http://i.imgur.com/ZDNiTSS.png)
- Overview: ![Overview](http://i.imgur.com/rYES5s1.png)
- Entry: ![Entry](http://i.imgur.com/NRyzOov.png)
- Edit: ![Edit entry](http://i.imgur.com/1xBI7IB.png)
- Logs: ![Log](http://i.imgur.com/F9S17Og.png)
- Public area: ![Public area](http://i.imgur.com/wohMCLH.png)

#Licese

This piece of software is licensed under MIT. See LICENSE.md for more information.

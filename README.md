Simple PHP Smarty blog
======================

Just a simple blog, coded with PHP, Smarty templates and MySQL.

This was coded as an academic assignment on 2010 for a web programming class.
There is code that doesn't follow best practices like in the JS files, maybe I will
update it at some point. Also the template files can be worked in a better way
adding a base template that can be extended than including specific templates
for the menu and headers for example in every other template.

To run you will need:
- HTTP server (Apache or Nginx)
- PHP
- MySQL
- Smarty templates (http://www.smarty.net/)

After you have everything:
- Create the SQL tables included in 'sql/tables.sql'
- Optional: load the data from 'sql/db_dump_01.sql' for examples
- Configure 'includes/mysql_data.php' with your mysql data.
- Configure 'includes/smarty_dir.php' with the path where smarty is installed

Released under MIT License.

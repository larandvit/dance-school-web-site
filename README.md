# Dance Scholl Web Site

## Description

The web site content is managed by Content Management System (CMS). 

Those pages can be changed by CMS.
* Home
    * News list
    * Events list
    * Slide show pictures
* News
* Events
* Gallery
* Schedule
* Fees

The main features are 
* Mobile ready.
* No middleware. Direct interaction of PHP with MySql.
* Dynamic HTML managed by javascript and jquery.
* Implemented script language to build rich web pages.  

## Setup
1. Copy www/html folder to your web server
2. Run db_scripts/create_sql_objects.sql script to generate a schema with tables and other sql objects
3. Run db_scrips/data/*.sql scripts to fill out the tables with data
4. Create a user with read-write permissions as per www/config.ini file
5. Place www/config.ini file in secure location and grant access to your web server
6. Generate a password for an admin or another user to access CMS

## Setup Files
1. BingSiteAuth.xml - Bing search engine file.
2. .htaccess - Apache config file to hide file extensions in web browser.
3. robots.txt - instruction to search engine: (1) don't index service folder where CMS code located and (2) location od site map file.
4. sitemap.xml - instruction to search engine which pages to index and how often to do it.

## Make Picture Folder Writable
```bash
sudo semanage fcontext -a -t httpd_sys_rw_content_t '[folder with pictures]'
sudo restorecon -v '[folder with pictures]'
```
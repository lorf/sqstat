    About SqStat
    ============

SqStat is a script which allows to look through active squid users
connections. It use cachemgr protocol to get information from squid
proxy server. Script homepage is http://samm.kiev.ua/sqstat/. 


    What's new
    ==========

For a complete list of changes, see the CHANGES file. 


    System requirements
    ===================

# PHP (you need PHP 4.1.0 or newer) with installed "pcre" extension
# Squid proxy server
# a web-browser (doh!)
# (optional) PHP session extension if you want to see current/average CPS


    Installation
    ============    

   1. Unpack the distribution in your webserver's document root.
   2. Copy file config.inc.php.defaults to config.inc.php, edit config.inc.php
      to specify your squid proxy server IP and port.
   3. Edit your squid.conf to allow cachemgr protocol:

      acl manager proto cache_object
      # replace 10.0.0.1 with your webserver IP
      acl webserver src 10.0.0.1/255.255.255.255
      http_access allow manager webserver
      http_access deny manager

   4. Point your browser to sqstat.php file and see what happens :)
   5. (optionally) enable ip resolving in config.inc.php. Also you can make 
      "hosts" like file with ip->name pairs.
   


    Bug reports
    ===========

If you have found what you believe to be a bug, you can send a bug
report to samm [at] os2.kiev.ua. Please, read FAQ before reporting.

Immobilienscout24 Tracker
=============
Use this PHP script to track the [Immobilienscout24](http://www.immobilienscout24.de) website for 
new entries of your specified search and send them to you as E-Mail.

How it works
-------
The PHP script parses the [Immobilienscout24](http://www.immobilienscout24.de) website and all 
found entries will be saved into a SQLite database. Every new run will compare the found entries 
with the database entries.

Prerequisites
-------
Create 'config.php' file using the config template 'config.sample.php' file.

Specify your search keys and your E-Mail sender and receiver address.
Keep in mind that this script uses the *mail()* function at the moment.

Installation
-------
Set up a cronjob or runwhen service to use 'tracker.php' to check for new entries every 30 minutes for example.

Console
-------
It's possible to run the 'tracker.php' PHP script in the console using the *-console* argument.

```
php tracker.php -console
```

There will be no E-Mail send and the found entries will be shown in the console.

Also you can use the *-verbose* argument to get information about the progress.

```
php tracker.php -console -verbose
```

Template
-------
You can customize yours E-Mails and Console output using the 'email.template.php' and 'console.template.php' files.

Libraries
-------
[PHP Simple HTML DOM Parser] (http://simplehtmldom.sourceforge.net/)

License
-------
Project is available under the [MIT license] (http://opensource.org/licenses/MIT).

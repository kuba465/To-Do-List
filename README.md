To-Do-List by Jakub Paluszkiewicz
==========

## Project that I created during my course in CodersLab

# Technologies
I wrote this app in Symfony. I used Doctrine, FOSUserBundle, JMSSerializerBundle, JavaScript/jQuery, AJAX.
I musted to use JMS SErializer, because I made a huge mistake when I designed my database.
There was unfortunately circural references.
## Edit
I repaired circural references. There is still that mistake in database, but now page is loading very fast. Page was loading so slow because JMS was generated very big files. I resolved this issues and now it's ok.

# Functionalities
- you can add categories and then tasks to categories
- every task can have: priority, date to do, description
- to every task you can add comments
- few more

# Things to make someday
- add admin panel(better priorities, users manager)
- add sorting function (by priorities, date, etc.)
- better look :)

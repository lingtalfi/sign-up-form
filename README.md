Inscription form
=======================
2016-11-15



A php "register form" pattern.



[![design.png](https://s19.postimg.org/529szbvmr/design.png)](https://postimg.org/image/6u2ru8ezj/)


Why?
--------
Tired of implementing "sign up" forms from scratch.


Features & dependencies
--------------

- form with 2 fields: email, password
- error handling: email already exist, email invalid, password invalid
- insert an user in the database upon successful form post (no email confirmation)


Dependencies: I use [QuickPdo](https://github.com/lingtalfi/QuickPdo) for interaction with database. 
It's easy to replace QuickPdo with your own system though.



How?
------------

First, you need a table named users, containing at least the three columns id, email, password (or adapt the script to your needs otherwise).


Open the inscription.php script: it contains

- the php script (top of the file)
- the html code (bottom of the file)


Paste those in your application where it fits.

The css is in the styles.css file. It's just a base design to save you 10 minutes+,
but you will probably want to remove/add some css rules to it.







Boring and technical comments
-----------------------------------

So this is the first step.
Next
- we need to include google, facebook and github one click registration techniques.
- when the form is posted, maybe add the email handling part
- add captcha?
- when the form is posted and there is an error, use javascript to remove the errors upon blur?




Related
===================
You might be interested in those other scripts as well:

- https://github.com/lingtalfi/sign-in-form
- https://github.com/lingtalfi/session-user







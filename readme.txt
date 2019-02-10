=== Stop Spammers ===

Contributors: bhadaway, Keith Graham
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DTRTUYSPKJN8N
Tags: spam, antispam, anti-spam, spam blocker, block spam, signup spam, comment spam, spam filter, registration spam, spammer, spammers, spamming, xss, malware, virus, captcha, comment, comments, contact, contact form, contact forms, form, forms, login, multisite, protection, register, registration, security, signup, trackback, trackbacks, user registration spam, widget
Tested up to: 5.0
Stable tag: trunk
License: https://www.gnu.org/licenses/gpl.html

Aggressive anti-spam plugin that eliminates comment spam, trackback spam, contact form spam, and registration spam. Protects against malicious attacks.

== Description ==

Stop Spammers is an aggressive website defence against comment spam and login attempts. It is capable of performing more than 20 different checks for spam and malicious events and can block spam from over 100 different countries.

Stop Spammers uses multiple methods for detecting spam and may be too aggressive for some websites.

In cases where spam is detected, users are offered a second chance to post their comments or login. Denied requests are presented with a CAPTCHA screen in order to prevent users from being blocked. The CAPTCHA can be configured as OpenCaptcha, Google reCAPTCHA or SolveMedia CAPTCHA. The CAPTCHA will only appear when a user is denied access as a spammer.

*Created with a lot of hard work and maintained by Keith P. Graham (from 2010-2017). Thank you Keith.*

*Maintained (because I love this plugin and want to keep it alive) by Bryan Hadaway (since 2017).*

***If you also love this plugin and want to see it live on, you can help me maintain it [on GitHub](https://github.com/bhadaway/stop-spammers).***

***Need help? Read the [FAQs page](https://github.com/bhadaway/stop-spammers/wiki/faqs) first.***

== Installation ==

Go to "Add New" from your WP admin menu, search for Stop Spammers, and install.

OR

1. Download the plugin.
2. Upload the plugin to your wp-content/plugins directory.
3. Activate the plugin.
4. Under the settings, review options that are enabled. The plugin will operate very well straight out of the box. However, you may wish to update Web Service APIs for reporting spam and change the CAPTCHA settings from the default.  

== Changelog ==

= 7.1 =
* fixed IP blacklisting (thanks https://github.com/peterjanes)
* added SFS reporting from the log page (thanks https://github.com/peterjanes)
* cleaned up a few typos
* removed automatic migration of settings from old versions prior to 7.0 (if upgrading from 6.x, start with 7.0.9 — then upgrade to the very latest version)
* removed whitespace from textareas

= 7.0.9 =
* encrypted all external links

= 7.0.8 =
* formatted code according to WP PHP coding standards (https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/) — it's no where near perfect, but it's a step in the right direction

= 7.0.7 =
* fixed MySQL errors for threat scan (thanks https://github.com/stodorovic)
* less memory used for wp-login.php checks (thanks https://github.com/stodorovic)

= 7.0.6 =
* fixed issue with menu icon
* added link to new FAQs (https://github.com/bhadaway/stop-spammers/wiki/faqs)
* removed debug submission form (not needed)

= 7.0.5 =
* fixed SFS reporting

= 7.0.4 =
* fixed login issue

= 7.0.3 =
* fixed SFS report messages
* continued general cleanup
* continued design improvements
* removed email notifications for admin logins

= 7.0.2 =
* continued general cleanup
* continued design improvements
* reorganized menu
* reintroduced beta features
* removed add-ons

= 7.0.1 =
* continued general cleanup
* continued design improvements
* a few small fixes
* better menu icon

= 7.0 =
* fixed XSS error
* general cleanup
* design improvements
* transferred control to new developer
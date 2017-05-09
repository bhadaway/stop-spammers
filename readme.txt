=== Stop Spammers ===

Contributors: Keith Graham, bhadaway
Tags: spam, antispam, anti-spam, spam blocker, block spam, signup spam, comment spam, spam filter, registration spam, spammer, spammers, spamming, xss, malware, virus, captcha, comment, comments, contact, contact form, contact forms, form, forms, login, multisite, protection, register, registration, security, signup, trackback, trackbacks, user registration spam, widget
Tested up to: 4.7.4
Stable tag: trunk
License: https://www.gnu.org/licenses/gpl.html

Aggressive anti-spam plugin that eliminates comment spam, trackback spam, contact form spam, and registration spam. Protects against malicious attacks.

== Description ==

Stop Spammers is an aggressive website spam defence against comment spam and login attempts. It is capable of performing more than 20 different checks for spam and malicious events and can block spam from over 100 different countries.

Stop Spammers uses multiple methods for detecting spam and may be too aggressive for some websites.

In cases where spam is detected, users are offered a second chance to post their comments or login. Denied requests are presented with a CAPTCHA screen in order to prevent users from being blocked. The CAPTCHA can be configured as OpenCaptcha, Google reCaptcha, or SolveMedia CAPTCHA. The CAPTCHA will only appear when a user is denied access as a spammer.

Created and maintained by Keith P. Graham (since 2010). Maintained by Bryan Hadaway (since 2017).

== Installation ==

Go to "Add New" from your WP admin menu, search for Stop Spammers, and install.

OR

1. Download the plugin.
2. Upload the plugin to your wp-content/plugins directory.
3. Activate the plugin.
4. Under the settings, review options that are enabled. The plugin will operate very well straight out of the box. However, you may wish to update Web Service APIs for reporting spam and change the CAPTCHA settings from the default.  

== Changelog ==

= 7.0 =
* general cleanup
* design improvements
* fixed XSS error
* transferred control to new developer
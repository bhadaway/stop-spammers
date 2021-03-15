=== Stop Spammers ===

Author: Trumani
Plugin URI: https://stopspammers.io/
Contributors: trumani, bhadaway, hiteshchandwani, Keith Graham
Donate link: https://stopspammers.io/donate
Tags: spam, security, anti-spam, spam blocker, block spam, signup spam, comment spam, spam filter, registration spam, spammer, spammers, spamming, xss, malware, virus, captcha, comment, comments, login, protection, user registration spam
Version: 2021.7
Tested up to: 5.7
License: https://www.gnu.org/licenses/gpl.html

Robust WordPress security & spam prevention. Leverage our pre-defined allow/block lists. Adjust configurable security settings on hyphens, periods, too many hits, quick responses, & much more. Manage custom lists for IPs, emails, usernames, and spam words. Run diagnostic testing and log reporting.

== Description ==

Stop spam emails, spam comments, spam registration, and spam bots and spammers in general. Run diagnostic tests, view activity, and much more with this well-maintained, mature plugin.

Stop Spammers adds security that should kill off many of your spam worries straight out-of-the-box. Because every website is different (especially if you have integrated a payment gateway), we offer dozens of features you can leverage to meet your website's specific needs. Our 50+ configuration options make personalization easy.

Get even more options with <strong><a href="https://stopspammers.io/downloads/stop-spammers-premium/">Stop Spammers Premium</a></strong>.

**Features**

Extremely granular control, so that any variety of website can create a special custom cocktail just for their particular spam issues:

* Block suspicious behavior
* Block IPs found in public blacklists
* Block spam words
* Block disposable emails
* Block URL shortening services
* Block TLDs
* Block countries
* Block/allow IPs, emails, and usernames manually
* Block admin notices permanently
* Send email when allow list request is approved
* Members-only mode
* So much more...
* Server-level firewall protection (Premium Only)
* Themed registration/login pages and menu links (Premium Only)
* Brute force login protection (Premium Only)
* Notification control (Premium Only)
* Import/export settings (Premium Only)
* Export log to Excel (Premium Only)
* Restore default settings (Premium Only)
* Contact Form 7 protection (Premium Only)
* Built-in contact form (Premium Only)

== Installation ==

The most powerful spam prevention for WordPress: 50+ spam-blocking settings, dianostic testing, log reports, and much more.

Go to *Plugins > Add New* from your WP admin menu, search for Stop Spammers, install, and activate.

OR

1. Download the plugin and unzip it.
2. Upload the plugin folder to your wp-content/**plugins** folder.
3. Activate the plugin from the plugins page in the admin.

== Frequently Asked Questions ==

= What do I do if I lock myself out of my own site? =

See: [https://github.com/trumani/stop-spammers/issues/5](https://github.com/trumani/stop-spammers/issues/5).

= Can I use Stop Spammers with Cloudflare? =

Yes. But, you may need to restore visitor IPs: [https://support.cloudflare.com/hc/sections/200805497-Restoring-Visitor-IPs](https://support.cloudflare.com/hc/sections/200805497-Restoring-Visitor-IPs).

= Can I use Stop Spammers with WooCommerce (and other ecommerce plugins)? =

Yes. But, in some configurations, you may need to go to Stop Spammers > Protection Options > Toggle on the option for "Only Use the Plugin for Standard WordPress Forms" > Save if you're running into any issues.

= Can I use Stop Spammers with Akismet? =

Yes. Stop Spammers can even check Akismet for an extra layer of protection.

= Can I use Stop Spammers with Jetpack? =

Yes and no. You can use all Jetpack features except for Jetpack Protect, as it conflicts with Stop Spammers.

= Can I use Stop Spammers with Wordfence (and other spam and security plugins)? =

Yes. The two can compliment each other. However, if you have only a small amount of hosting resources (mainly memory) or aren't even allowing registration on your website, using both might be overkill.

= Why is 2FA failing? =

Toggle off the "Check Credentials on All Login Attempts" option and try again.

= Is Stop Spammers GDPR-compliant? =

Yes. See: [https://law.stackexchange.com/questions/28603/how-to-satisfy-gdprs-consent-requirement-for-ip-logging](https://law.stackexchange.com/questions/28603/how-to-satisfy-gdprs-consent-requirement-for-ip-logging). Stop Spammers does not collect any data for any other purpose (like marketing or tracking). It is purely for legitimate security purposes only. Additionally, if any of your users ever requested it, all data can be deleted.

== Changelog ==

= 2021.7 =
* [Update] PayPal IPs
* [Enhanced] Cleanup

= 2021.6 =
* [New] Notification Control feature
* [New] Sortable registered date column on Users page
* [Enhanced] Security
* [Enhanced] Code audit and cleanup

= 2021.5 =
* [Fix] Email fix

= 2021.4 =
* [Fix] SFS report fix

= 2021.3 =
* [Fix] Error fixes

= 2021.2.1 =
* [Fix] Login issue

= 2021.2 =
* [New] Strings are now translation-ready
* [Update] UI improvements
* [Update] Safety checks for WooCommerce
* [Enhanced] When approving allow requests, the email address is now whitelisted
* [Enhanced] Code audit and cleanup
* [Fix] "Clear the Requests" toggles off other settings
* [Fix] Too many periods feature

= 2021.1 =
* [Update] Third-party service IP lists

= 2021 =
* [New] Private mode feature
* [Update] UI improvements
* [Enhanced] Too many periods feature
* [Enhanced] Emails are now off by default (to avoid potential issues with server reputation)
* [Enhanced] Code audit and cleanup
* [Fix] Shortened URL option only checks for exact matches now

= 2020.6.2 =
* [Update] Minor UI improvements
* [Fix] Duplicate email issue

= 2020.6.1 =
* [Fix] PHP notice

= 2020.6 =
* [New] Send email when allow list request is approved (community request)
* [New] Approve or Block action in request email with link to Allow List page (community request)
* [Update] Update Stop Spammers menu icon to 'S' logo
* [Fix] Conditional fields hidden on page load when option is enabled
* [Fix] Updates to multisite (community reported)
* [Fix] Shortcode and HTML support on Spam Message (community reported)
* [Fix] Wrong key used for the spam reason in the allow request email template sent to the web admin

= 2020.5.1 =
* [Fix] Block if email has too many periods

= 2020.5 =
* [New] Block URL shortening service links

= 2020.4.5 =
* [New] Notice

= 2020.4.4 =
* [Fix] PHP warnings

= 2020.4.3 =
* [Enhanced] Code cleanup

= 2020.4.2 =
* [Revert] Removed gettext

= 2020.4.1 =
* [Fix] Hotfix

= 2020.4 =
* [New] Force username-only login
* [New] Force email-only login
* [New] Disable custom passwords
* [Enhanced] 2,500+ disposable email domains added to block list
* [Update] Support notice

= 2020.3 =
* [Update] Usability updates

= 2020.2 =
* [Update] Plugin audit and cleanup

= 2020.1.1-2020.1.4 =
* [Update] Various hotfixes

= 2020.1 =
* [New] Check for Tor Exit Nodes
* [New] Check for too many periods
* [New] Check for too many hyphens
* [New] Allow Stripe
* [New] Allow Authorize.Net
* [New] Allow Braintree
* [New] Allow Recurly
* [Update] Admin UI enhancements

= 2019.6 =
* [New owner](https://github.com/trumani/stop-spammers/issues/145)
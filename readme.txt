=== Anti-Spam: Spam Protection | Block Spam Users, Comments, Forms ===

Contributors: mcitar, bhadaway
Donate link: https://calmestghost.com/donate
Tags: spam, security, anti-spam, spam protection, no spam
Tested up to: 6.5
Requires at least: 3.0
Requires PHP: 5.0
Stable tag: 2024.6
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

Robust security and spam prevention. Leverage our pre-defined allow/block lists. Adjust configurable settings on too many hits, quick responses, etc.

== Description ==

Antispam.

Stop spam emails, spam comments, spam registration, and spam bots and spammers in general. Run diagnostic tests, view activity, and much more with this well-maintained, mature plugin.

Stop Spammers adds security that should kill off many of your spam worries straight out-of-the-box. Because every website is different (especially if you have integrated a payment gateway), we offer dozens of features you can leverage to meet your website's specific needs. Our 50+ configuration options make personalization easy.

**Features**

Extremely granular control, so that any variety of website can create a special custom cocktail just for their particular spam issues:

* Block suspicious behavior
* Block spam words, disposable emails, URL shortener links, all URLs TLDs and more
* Connect third-party spam defense services
* Block countries
* Block/allow IPs, emails, and usernames manually
* Hide admin notices permanently
* Allow users to request access and send email when allow list request is approved
* Members-only mode
* Core forms CAPTCHA
* Mass lookup and disable registered users and pending comments
* Disable WordPress automated emails

We sincerely thank everyone who has contributed to the project through donations, feedback, and bug reporting. Every little bit goes a long way.

== Installation ==

The most powerful spam prevention for WordPress: 50+ spam-blocking settings, dianostic testing, log reports, and much more.

Go to *Plugins > Add New* from your WP admin menu, search for Stop Spammers, install, and activate.

OR

1. Download the plugin and unzip it.
2. Upload the plugin folder to your wp-content/**plugins** folder.
3. Activate the plugin from the plugins page in the admin.

== Frequently Asked Questions ==

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

= 2024.6 =
* [Fix] AJAX script JSON error handling
* [New] Added version numbering to enqueued script and style files

= 2024.5 =
* [Enhanced] Security

= 2024.4 =
* [Notice] Premium has been discontinued
* [Notice] HiveMind API has been discontinued

= 2024.3 =
* [Notice] We're making a big push to audit Stop Spammers — now's the time to jump in if you know how to code and can contribute fixes: help@stopspammers.io.

= 2024.2 =
* [Notice] We're making a big push to audit Stop Spammers — now's the time to jump in if you know how to code and can contribute fixes: help@stopspammers.io.

= 2024.1 =
* [Update] readme

= 2024 =
* [Fix] Arithmetic captcha

= 2023.4.1 =
* [Update] Toggle hotfix

= 2023.4 =
* [New] Check for any URL posted in a comment

= 2023.3 =
* [New] User filter/lookup to find spam registrations based on email top level domain, where first name = last name, and comment history
* [New] Mass disable users
* [New] Mass delete pending comments

= 2023.2 =
* [New] Disable WordPress admin email notifications

= 2023.1 =
* [Fix] Escape code

= 2023 =
* [Enhanced] Security

= 2022.6 =
* [Enhanced] Security

= 2022.5 =
* [Update] Thank you message

= 2022.4 =
* [New] Add IP addresses from comments to allow or block list
* [Update] Thank you message

= 2022.3 =
* [Fix] JavaScript error

= 2022.2 =
* [Update] Allowing users with older versions of PHP to upgrade

= 2022.1 =
* [New] Fundraising campaign

= 2022 =
* [New] HiveMindᴮᴱᵀᴬ — A community IP block list (limited)
* [Fix] CAPTCHAs

= 2021.20 =
* [Fix] PHP 8 error

= 2021.19 =
* [New] Enable CAPTCHA on WordPress core forms

= 2021.18 =
* [Enhanced] Security

= 2021.17 =
* [New] hCaptcha integration

= 2021.16 =
* [New] Allow Square

= 2021.15 =
* [Fix] Checking for periods in emails
* [Fix] jQuery error

= 2021.14 =
* [Fix] Network toggle fix
* [Fix] Design issue with icons on some browsers

= 2021.13 =
* [Update] Cloudflare IPs
* [Fix] SFS report

= 2021.12 =
* [Fix] Minor fixes

= 2021.11 =
* [Fix] Settings fix

= 2021.10 =
* [Enhanced] Security

= 2021.9 =
* [Enhanced] Security

= 2021.8 =
* [Update] UI improvements
* [Enhanced] Notification Control feature
* [Fix] Math question

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
* New owner

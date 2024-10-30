=== Chatbot Botnation Plugin ===
Contributors: llienard
Tags: botnation,chatbot,bot,web
Requires at least: 4.0
Tested up to: 6.0
Stable tag: 1.3.3
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allow you to add your Botnation AI Chatbot on your Wordpress website.

== Description ==

Chatbot Botnation plugin will allow you to set up a chatbot built with Botnation AI on your WP site.

If you want to use this plugin you need:

1. Create your account and [chatbot on Botnation.ai](https://botnation.ai) Creating an account and the bot builder are free.
1. Approve the [Terms & Conditions](https://botnation.ai/en/cgu.html) of Botnation AI and fill out the information form.
1. Build your web bot.

If the user is identified, the plugin will automatically send to Botnation the following information from the person connected to the WP website: ID / Firstname / Lastname.

If the user is anonymous, the plugin will only send the IP of the user (for legal reasons).

= Translation =
* French (fr_FR)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/chatbot-botnation` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the "Plugins" menu in WordPress.
1. Use the Settings > Chatbot Botnation screen to configure the plugin.
1. Fill the required fields in the form.
1. Enjoy !

== Frequently Asked Questions ==

= Do I need a Botnation account ? =

Yes, you need to create your Botnation account on [Botnation AI](https://botnation.ai).

== Changelog ==

= 1.3.3 =
* Support Wordpress 6.0

= 1.3.2 =
* Support Wordpress 5.9

= 1.3.1 =
* Support Wordpress 5.9

= 1.3.0 =
* Support PHP8

= 1.2.6 =
* Support Wordpress 5.8

= 1.2.5 =
* Loads the chatbot when the page is fully loaded
* No longer preload the conversation for faster page loading

= 1.2.4 =
* Add an option to put your Chatbot in full screen.
* Add an option to insert the discussion in an HTML element.
* Add an option to change your Chatbot interface language.
* Allows you to send Botnation variables to Chatbot.
* Allows you to have different Chatbots on each page.

= 1.2.3 =
* Fixed an incompatibility with WooCommerce.

= 1.2.2 =
* Fixed a bug that prevented to save settings.

= 1.2.1 =
* Added french translations.

= 1.2.0 =
* Override the default settings for a specific page. You can now :
1. Force to open automatically the chat on a specific page.
1. Restart the conversation on a specific sequence on a specific page.

= 1.1.0 =
* Set connected user datas (ID, firstname, lastname) for botnation chatbot.
= 1.0.0 =
* Initial release.

=== Google forms Shortcode ===
Contributors: zjuul
Tags: google, forms, google forms, shortcode, iframe
Requires at least: 2.8
Tested up to: 2.9.2
Stable tag: 1.0

This plugin adds the possibility to easily insert forms created by Google
docs into pages and posts using a shortcode.

== Description ==

This plugin adds the possibility to easily insert forms created by Google
docs into pages and posts using a shortcode.
It also contains options for default settings, so you don't have to change
all iframe codes if you e.g. change the width of your content column.

The following options are supported:

* default width
* default height
* default "loading" text
* default error message

== Installation ==

1. Upload the googleforms-shortcode directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Optionally set the default behaviour (width, height, etc)
1. Insert a code like [googleform key="abcdef"] in a post or page and you're set.

== Frequently Asked Questions ==

Q: What shortcode attributes are supported?
A: id (mandatory), width, height, text

Q: Can you give me an example?
A: Yes: [googleform key="abcdef" heigth="600" width="500" text="Moment please"]

Q: How do I find the right Key?
A: From the URL Google creates. It's in the form of
http://spreadsheets.google.com/viewform?formkey=sdflkajnsdflKJNsdfkjnRkjnlnlkjnlnn
In this case, the key is sdflkajnsdflKJNsdfkjnRkjnlnlkjnlnn


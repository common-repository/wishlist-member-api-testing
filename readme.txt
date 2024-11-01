=== Wishlist Member API Testing ===
Contributors: HappyPlugins
Tags: Wishlist Member, Membership Platforms
Donate link: http://happyplugins.com
Requires at least: 4.4
Tested up to: 4.4
Stable Tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Test Wishlist Member API on your server 

== Description ==
Wishlist Member API Testing allows you to check if your connection to Wishlist Member plugin internal & external API is working correctly in real time.

<strong>Why would I want to test the API connection?</strong>

Here are only few of the reasons you would want to check your website's connection to Wishlist Member's API:

* To make sure Wishlist Member API is working and functioning correctly
* API connection error will make the 3rd party plugins not to work
* Shorten the time to troubleshoot any issues and problems with caused by Wishlist Member API problems.

<strong>How Wishlist Member API Testing plugin works?</strong>

Wishlist Member is required in order to use Wishlist Member API Testing plugin.
Here are the steps to using Wishlist Member API Testing plugin:

1. Download the plugin from WordPress.org
2. Install and activate it on your Wishlist Member membership site
3. Go to the Tools menu > Wishlist Member API Testing

<strong>Why Wishlist Member API sometimes do not work?</strong>

Wishlist Member external API is calling a specific URL that's designed by Wishlist Member to accept API requests.<br>In order not to accept just any request Wishlist Member need to authenticate the API call using the Wishlist Member API Key (which is defined in the Wishlist Member settings).<br>After the API connection is established and authenticated an API request can be made.

The Wishlist Member API call can fail from the main following reasons: 

1. The API was not authenticated correctly.
2. The API call is getting a result from the cache and only the first API call succeed and all the following calls will fail.
3. Plugin conflict with caching or security plugins that are installed on the WordPress installation or on your server. These plugins prevent  the URL call and cause the API request to fail.
4. Server or PHP settings that prevent the API from being authenticated correctly.
5. DNS servers or CDN services than can cache or redirect the API URL to an incorrect URL, causing the Wishlist Member API not to be authenticated correctly and fail.

These are only few of the reasons that can cause a problem. Because it's impossible to predict the results or isolate the cause in all cases we have created this plugin which identify that there is some kind of  problem with the Wishlist Member external API.

<strong>Who is behind Wishlist Member API Testing plugin?</strong>

Wishlist Member API Testing was developed by [HappyPlugins](https://happyplugins.com/downloads/category/wishlist-member/?utm_source=wordpress-repository&utm_medium=wlm-api-testing&utm_campaign=WishlistMemberCategory) Company that developed hundreds of plugins for the Wishlist Member platform, both commercial and non-commercial.
All of our developers are Wishlist Member certified and are familiar with the Wishlist Member code and API from inside out.

<strong>Recommended Resources:</strong>

[HappyPlugins.com/Wishlist-Member](https://happyplugins.com/downloads/category/wishlist-member/?utm_source=wordpress-repository&utm_medium=wlm-api-testing&utm_campaign=WishlistMemberCategory) - Wishlist Member Dedicated Plugins
[WishlistMemberPlugins.net](http://wishlistmemberplugins.net/wishlist-member-tips-list) - Our Free Wishlist Member Tips Series
[WishlistMemberDevelopers.com](http://wishlistmemberdevelopers.com) - Services for Wishlist Member Users


== Installation ==
1. Download Wishlist Member API Testing plugin from WordPress.org
2. Upload the plugin's zip file to "wp-content/plugins/" directory of your website
3. Activate the plugin through the "Plugins" menu in your WordPress website


== Frequently Asked Questions ==
<strong>Do this plugin have any conflict with other plugins?</strong><br>
As far as we know, Wishlist Member API Testing does not have any conflicts with other plugins.
The plugin was developed according to the WordPress.org guidelines, so the chances that it causes any issues or conflicts are very low.
If you have any problems or conflicts, please try to disable the plugin and see if the problem still consists.
It the problem still consists, please share it in the support tab so we can troubleshoot the issue.

<strong>Who is behind Wishlist Member API Testing plugin?</strong><br>
Wishlist Member API Testing was developed by HappyPlugins Company that developed hundreds of plugins for the Wishlist Member platform, both commercial and non-commercial.
All of our developers are Wishlist Member certified and are familiar with the Wishlist Member code and API from inside out.

<strong>Why would I want to test the API connection?</strong><br>
Here are only few of the reasons you would want to check your website's connection to Wishlist Member's API:
To make sure the plugin is working and functioning correctly
API connection error will make the integrations not to work
Shorten the time to troubleshoot any issues and problems with the integrations

== Upgrade Notice == 

Update your plugins

== Screenshots ==

Screenshots coming soon

== Changelog ==
1.0.4
+ Fixed scripts loading location
+ Updated offical Wishlist Member wlmapiclass to version 1.6

1.0.3
+ Fixed external raw response for levels request

1.0.2
+ Added Support for both internal & external API
+ Added Support for member registration tests.


1.0.1

+ Initial version
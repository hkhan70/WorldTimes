=== SimpleForm Contact Form Submissions ===
Contributors: simpleform
Donate link: https://wpsform.com/
Tags: contact form, email manager, crm, database, simpleform addon, emails, comments, feedback, wordpress form plugin, simple, form builder, form maker
Requires at least: 4.7
Tested up to: 5.5
Requires PHP: 5.6
Stable tag: 1.4.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A data storage plugin created specifically for SimpleForm. It allows you to save data in the database, and manage the messages from the dashboard.

== Description ==

Thanks to this lightweight plugin, you can view all data sent through the contact form in a sortable table form, or retrieve only data you need from the WordPress database by using the date filter or the search box. You can permanently delete the messages, move the messages to the trash or restore them from the trash. Select columns and pagination from “Screen Options”. No configuration required. Once activated, you will find the new “Data Storing” option in the Settings page. Make sure to keep this option enabled, and you no longer need to worry about losing important messages, since each new form submission will be stored in your WordPress database!

For more detailed information refer to the [SimpleForm](https://wordpress.org/plugins/simpleform/) plugin page.

https://www.youtube.com/watch?v=XiiQUWFTF4E&rel=0

== Installation ==

Activating the SimpleForm Contact Form Submissions plugin is just like any other plugin.

= Using the WordPress Dashboard =

1. Navigate to “Add New” in the plugins dashboard
2. Search for “SimpleForm Contact Form Submissions”
3. Click “Install Now”
4. Activate the plugin in the Plugin dashboard

= Uploading into WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select “simpleform-submissions.zip” in your computer
4. Click “Install Now”
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download “simpleform-submissions.zip”
2. Extract the “simpleform-submissions” directory in your computer
3. Upload the “simpleform-submissions” directory to the /wp-content/plugins/ directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= Can I install this plugin without SimpleForm? =

No. You cannot. You need SimpleForm to activate this plugin.

= Why is this feature not integrated into the SimpleForm plugin? =

We have designed SimpleForm to be a minimal, lightweight, fast and privacy-respectful plugin, and we want to keep it that way. You can choose to enable this feature at any time, and with a single click, depending on your needs.

= Where can I check my form submissions? =

Make sure you have selected the “Data Storing” option in the Settings page within the General tab, then open the Submissions page.

= How can I disable storing submissions to the WordPress database? =

Go to the Settings page within the General tab and uncheck the “Data Storing” option. The submissions list in the dashboard will be removed. User data storing will be disabled, and this data will be included only within the notification email.

= Can I disable only the IP address storing? =

Of course. You can select this option in the Settings page within the General tab.

= How to make SimpleForm meet the GDPR conditions? = 

This plugin stores personal data collected through the contact form. Enable the “Consent Field” in the Form Editor page and make it a required field for requesting the user’s explicit consent. 

= What is the name of the table where the data is stored? = 

The table name is "wp_sform_submissions", but if you changed your WordPress MySQL table prefix from the default "wp_" to something else, this table will also have that prefix.

== Screenshots ==

1. Settings page
2. Submissions page
3. Submitted message page
4. Consent field for GDPR compliance

== Changelog ==

= 1.4.3 (26 November 2020) =
* Fixed: database update error on updating
* Fixed: notification bubble error

= 1.4.2 (26 November 2020) =
* Added: compatibility with SimpleForm 1.10 version

= 1.4.1 (16 November 2020) =
* Changed: minor issues in code
* Fixed: error during plugin deactivation if SimpleForm plugin is missing
* Fixed: error during messages status update if plugin is already active

= 1.4 (14 November 2020) =
* Changed: code cleaning
* Added: unread view for the submissions
* Added: option for change the columns that must be displayed in the submissions table
* Added: option for add a notification bubble to contacts menu item for unread messages
* Added: action links in the plugins page

= 1.3.3 (19 September 2020) =
* Fixed: error loading the language packs for translation

= 1.3.2 (18 September 2020) =
* Fixed: error during saving settings

= 1.3.1 (11 August 2020) =
* Fixed: security issue
* Fixed: typo errors

= 1.3 (27 June 2020) =
* Added: trash status and related view for the submissions list
* Fixed: pagination error when the number of submissions per page is changed

= 1.2.1 (10 May 2020) =
* Fixed: database update error on updating
* Fixed: minor issues in code

= 1.2 (1 May 2020) =
* Added: date filter
* Fixed: minor issues in code

= 1.1.4 (11 April 2020) =
* Fixed: search for last name and phone missing
* Fixed: unexpected output error during plugin activation
 
= 1.1.3 (1 April 2020) =
* Fixed: database update error on updating

= 1.1.2 (31 March 2020) =
* Fixed: database update errors
* Fixed: undefined index errors

= 1.1.1 (27 March 2020) =
* Added: compatibility with SimpleForm 1.5 version
* Fixed: SQL injection vulnerability issues
* Fixed: minor issues in code

= 1.1 (15 February 2020) =
* Added: search box

= 1.0 (15 January 2020) =
* Initial release

== Demo ==
 
You don’t know SimpleForm yet? Check out our [Demo](https://wpsform.com/demo/) and find out how it works.

== Credits ==
 
We wish to thank everyone who has contributed to SimpleForm Contact Form Submissions translations. We really appreciate your time, your help and your suggestions.

* English (UK): Mark Scott Robson
* Italian: Gianluca, Luisa Ravelli
* Portuguese (Portugal): Pedro Mendonça
* Romanian: Dan Caragea
* Spanish (Spain): Javier Esteban
* Spanish (Mexico): Javier Esteban
* Spanish (Venezuela): Javier Esteban
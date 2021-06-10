                                                                                                                === SimpleForm – The simplest way to add a contact form ===

Contributors: simpleform
Donate link: https://wpsform.com/
Tags: contact form, custom form, email, forms, smtp, feedback, anti-spam, captcha, ajax, contact form plugin, contact us page, form builder, contact, mail, antispam
Requires at least: 4.7
Tested up to: 5.6
Requires PHP: 5.6
Stable tag: 1.10.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple and effective contact form. Ready to use, thanks to the SMTP setup options.

== Description ==

SimpleForm is a very simple to manage plugin for creating a basic contact form for your website. Here are some reasons to use it:

= Easy to use =

This plugin is very easy to set up thanks to a graceful and intuitive admin interface. You can quickly create a contact form by using our pre-built page or copying a shortcode to where you want it to appear.

= Fully customizable =

It allows you to customize everything you want. You can decide which fields to display and what kind of user can see them. You can decide which fields are required and which are not. You can change or hide the field labels, choose the labels placement and how required fields are marked, set a minimum or maximum length for text fields, use placeholders, decide what message to display when an error occurs and how to set focus on errors. You can add customized text above and below the form, you can choose a template based on your tastes or you are free to create and use a personal template for your contact form, you can add your own customized JavaScript code or CSS stylesheet.

= Ready to use =

It comes with the SMTP option for outgoing email to be ready to use immediately. This feature makes it less likely that email sent from your website is marked as spam and lowers the risk of email getting lost somewhere.

= Clean design =

We love clean and minimalist design, and for this reason we provide a contact form that is both simple and appealing.

= Designed thinking about the user experience =

It is a lightweight and responsive plugin. SimpleForm does not interfere with your site performance. The submission via AJAX, on the backend too, allows a seamless user experience without page refreshes. You can show users a success message or redirect them elsewhere after they complete the form. You can also send a confirmation email to thank whoever contacts you.

https://www.youtube.com/watch?v=syaUMA6pK4g&rel=0

**What SimpleForm is not for now:**

There is still much to be done! For now, you cannot add new fields. Anti-spam options are limited to question/response fields and honeypot fields.

For complete information, please visit the [SimpleForm website](https://wpsform.com/).

== Installation ==

Activating the SimpleForm plugin is just like any other plugin.

= Using the WordPress Dashboard =

1. Navigate to “Add New” in the plugins dashboard
2. Search for “SimpleForm”
3. Click “Install Now”
4. Activate the plugin in the Plugin dashboard

= Uploading into WordPress Dashboard =

1. Navigate to “Add New” in the plugins dashboard
2. Navigate to the “Upload” area
3. Select “simpleform.zip” in your computer
4. Click “Install Now”
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download “simpleform.zip”
2. Extract the “simpleform” directory in your computer
3. Upload the “simpleform” directory to the /wp-content/plugins/ directory
4. Activate the plugin in the Plugin dashboard

= And once activated? =

You will find the new menu "Contacts" on the administration dashboard. Take the time to configure SimpleForm and open the "Settings" page listed below the new menu just added, make the changes desired, then click the "Save changes" button at the bottom. Now, you're able to add a contact form to your website.

== Frequently Asked Questions ==

= Who should use SimpleForm? =

Anyone who needs only what is strictly necessary. SimpleForm is designed for whoever is looking for a minimalist, friendly, and fully controllable contact form.

= Which form fields can be used? =

The standard fields that come with SimpleForm are a name field, a last name field, an email address field, a phone number field, a subject field, a message field and a consent checkbox field.

= Does SimpleForm include spam protection? =

Of course, it includes, by default, two honeypot fields, invisible spam protection to trick spambots into revealing themselves, and also allows you to enable an optional maths captcha field which requires human interaction. Google reCAPTCHA and Akismet are not yet supported.

= Does SimpleForm meet the GDPR conditions? = 

Yes, if you're collecting personal data, you can use a required checkbox for requesting the user's explicit consent.

= Why am I not receiving messages when users submit a form? =

You need to enable an SMTP server. You can install a dedicated plugin that takes care of outgoing email, or you can enable our SMTP option in the settings page. If you have done so already, verify the correct SMTP server configuration, and always keep the notification email option enabled.

= Where can I check the submissions of my form? =

SimpleForm doesn’t store submitted messages in the WordPress database by default. You can easily add this feature with the [SimpleForm Contact Form Submissions](https://wordpress.org/plugins/simpleform-contact-form-submissions/) addon. Without it, only the last message is temporarily stored. Therefore, it is recommended to verify the correct SMTP server configuration in case of use, and always keep the notification email enabled if you want to be sure to receive messages.

= Is SimpleForm translation ready? =

Yes, SimpleForm is ready to be translated into other languages. If you’re a polyglot, help us by translating it into your own language!

= Can I change text direction? =

Yes, you can change text direction from left to right and from right to left.

= Where can I get support? =

We provide free support in the WordPress.org plugin repository. Please log into your account. Click on “Support” and, in the “Search this forum” field, type a keyword about the issue you're experiencing. Read topics that are similar to your issue to see if the topic has been resolved previously. If your issue remains after reading past topics, please create a new topic and fill out the form. Before using the support channel, please have a look at our [FAQ section](https://wpsform.com/faq/), as it may help you to find the answer immediately.

== Screenshots ==

1. Submissions page
2. Form editor page
3. Settings page
4. Messages tab
5. Notifications tab
6. SMTP server configuration
7. Admin notification configuration
8. Auto responder configuration
9. Default form template
10. Form failed validation

== Changelog ==

= 1.10.1 (1 December 2020) =
* Fixed: PHP error while activating the plugin
* Fixed: undefined variable errors
* Fixed: minor issues in code
* Added: form selector in the submissions page

= 1.10 (25 November 2020) =
* Changed: code cleaning and minor improvements
* Added: widget
* Added: option for hiding the admin notices
* Added: action links in the plugins page

= 1.9.2 (19 October 2020) =
* Fixed: form fields styling issues
* Added: option for adding a link to privacy policy page

= 1.9.1 (8 October 2020) =
* Fixed: incorrect displaying of phone error message if AJAX is disabled
* Fixed: minor issues in code
* Changed: form editor page
* Changed: not inline error message option
* Added: submit position option
* Added: highlighted template
* Added: compatibility with version 1.4 of SimpleForm Contact Form Submissions

= 1.9 (14 September 2020) =
* Fixed: undefined index errors
* Added: option for marking optional fields instead of required fields
* Added: loading spinner option when AJAX is enabled
* Added: option for hiding the validation error message below the form 

= 1.8.4 (24 August 2020) =
* Fixed: error when saving the consent checkbox error message
* Fixed: incorrect displaying of error messages if the form is not validated
* Fixed: fields styling issues when the right-to-left option is enabled
* Fixed: form validation error when the phone field is required
* Fixed: typo errors
* Changed: reduction of the number of queries and options used
* Changed: initial settings during plugin activation
* Changed: code cleaning
* Added: transparent template

= 1.8.3 (11 August 2020) =
* Fixed: typo errors
* Added: option for sending a copy of the notification email 
* Changed: option labels

= 1.8.2 (30 July 2020) =
* Added: option for customizing the error message if the AJAX request fails
* Added: option for not using the email of the submitter when replying to a notification email
* Changed: settings page
* Changed: new smart tags for dynamically changing the auto-responder message
* Changed: ability to send notification email to multiple recipients 

= 1.8.1 (12 July 2020) =
* Added: alert for JavaScript disabled
* Changed: the empty field error option is not displayed unless the field is required
* Changed: better honeypot fields implementation

= 1.8 (1 July 2020) =
* Changed: JavaScript code optimization 
* Changed: all errors are now displayed in case of multiple invalid fields
* Added: option for changing focus on form errors
* Added: option for using a generic message without showing the minimum number of required characters in field length error messages
* Added: options for error messages in case of empty required fields

= 1.7 (1 June 2020) =
* Fixed: no text will be displayed above the form if nothing is entered in the form description option
* Fixed: incorrect displaying of error messages when the minimum field length option is used
* Fixed: undefined index errors
* Fixed: typo errors
* Changed: minor issues in code
* Added: option for labels position
* Added: option for using a word to mark required fields
* Added: option for right-to-left text direction
* Added: option for disabling HTML5 form validation
* Added: option for using a customized JavaScript code

= 1.6.1 (10 May 2020) =
* Fixed: installation error during new site creation on WordPress Multisite Network
* Fixed: dynamic SQL query issues
* Fixed: minor issues in code and localization
* Added: pre-built pages for contact form and thank you message
* Added: pages in draft status will be shown in selecting the confirmation message page

= 1.6 (14 April 2020) =
* Fixed: screen options button opening error
* Fixed: minor issues in code
* Added: option for adding a minimum length to text fields
* Added: option for adding a maximum length to text fields

= 1.5.1 (6 April 2020) =
* Fixed: unexpected error during plugin activation
* Fixed: display of errors when form submission is not executed via AJAX

= 1.5 (1 April 2020) =
* Fixed: minor issues in code
* Added: field for last name
* Added: field for phone

= 1.4 (14 March 2020) =
* Fixed: name validation error when name field is not required
* Fixed: dynamic SQL query issues
* Added: option for hiding asterisk in required fields
* Added: option for hiding labels
* Added: option for placeholders

= 1.3.2 (29 February 2020) =
* Fixed: sanitization of a variable not properly used inside JavaScript script
* Added: new Bootstrap template

= 1.3.1 (21 February 2020) =
* Fixed: HTML5 validation error when form submission is executed via AJAX
* Fixed: captcha field styling issues
* Changed: JavaScript code optimization
* Changed: readme.txt file content

= 1.3 (11 February 2020) =
* Added: HTML5 form validation
* Added: option for using a basic Bootstrap form template
* Added: option for disabling the default stylesheet
* Added: Bootstrap markup in contact form template
* Changed: form template code for quick and easy customization
* Changed: PHP regular expressions for validating form fields
* Changed: JavaScript code for input validation
* Fixed: admin notices in submissions page
* Fixed: typo errors

= 1.2 (15 January 2020) =
* Added: option for using a customized form template
* Added: compatibility with WordPress Multisite Network
* Added: compatibility with addon for submitted messages storing
* Fixed: public scripts and styles issues

= 1.1 (21 December 2019) =
* Added: option for adding text above the form
* Added: option for adding text below the form
* Fixed: form fields styling issues
* Fixed: typo errors

= 1.0.1 (9 December 2019) =
* Changed: readme.txt file content
* Fixed: form fields styling issues
* Fixed: Italian translation errors

= 1.0 (1 December 2019) =
* Initial release

== Upgrade Notice ==

= 1.0 =
Just released into the WP plugin repository.

== SimpleForm Demo ==

Find out how SimpleForm works, try our [Demo](https://wpsform.com/demo/).

== What feature do you wish SimpleForm had? ==

SimpleForm already contains many options for being a basic contact form, but there are many other features it lacks. Go to the [support forum](https://wordpress.org/support/plugin/simpleform/) and create a new topic with your ideas! We’ll do our best to include the missing features in forthcoming releases.

== Integrations ==

* <a href="https://wordpress.org/plugins/simpleform-contact-form-submissions/">SimpleForm Contact Form Submissions</a> – Database for SimpleForm. You no longer need to worry about losing important messages, since each new form submission will be stored in your WordPress database!

== Credits ==
 
We wish to thank everyone who has contributed to SimpleForm translations. We really appreciate your time, your help and your suggestions.

* Albanian: Besnik
* Dutch: Peter Smits
* English (South Africa): Ian Barnes
* English (UK): Mark Scott Robson
* Italian: Gianluca, Stefano Cassone, Luisa Ravelli
* Romanian: Dan Caragea
* Spanish (Colombia): Javier Esteban, Yordan Soares
* Spanish (Mexico): Javier Esteban, Yordan Soares, Ali Darwich, abramoca
* Spanish (Spain): Javier Esteban, Fernando Tellado, Yordan Soares
* Spanish (Venezuela): Javier Esteban, Yordan Soares
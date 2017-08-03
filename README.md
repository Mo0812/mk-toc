# MK Table of Contents Plugin

This Plugin adds a Table of Contents to a post via inserting the shortcode [toc].

**This Plugin is still in development and not stable!**

## Appearance

![Example ToC from this plugin](assets/screenshot-1.png)

## Installation
There will be serveral ways to install this plugin. For now there is only the way to get it from this repository.
### Download
Clone or Download the plugin from this repository and upload it in your WordPress instance under ```wp-content/plugins/mk-toc```. When you open the plugin section in your WordPress Admin Panel, you will see the plugin and just have to activate it.

For every update of the plugin you have to download and then upload the new versions again.

## Usage
This plugin creates a Table of Contents for a post at the position in text where the shortcode [toc] is inserted with the following rules:
* The shortcode generates the ToC only from the post content. 
* It scans all headings (```<h1>```...```<h5>```) and orders them on their appearance in the text.
* It will output a list with the generated ToC and put it at the position in text where the shortcode was set.
* All ToC recognized headings are shown as links with anchors to their appropriate heading in the text.
* A JavaScript part of the plugin also add anchor links above every recognized heading in the post content to make the anchor links work.
* Except the shortcode [toc] the plugin generates no changes in post content or other parts of the post. So it is no problem to deactivate the plugin.

## Shortcode
The shortcode [toc], introduced with this plugin, can have several option parameters:
* **title** (*optional*): This parameters takes a string and if its not emtpy it will show a headline above the generated ToC.
* **level_begin** (*optional*): *level_begin* determine at which heading level the ToC parsing should start. Cases can be that you want to exclude headings like ```<h1>```. The default behavoir is, that the ToC recognize all headings from ```<h1>``` to ```<h5>```.
* **level_end** (*optional*): *level_end* has the same functionality like *level_begin* but it limited the headings level from underneath. So you can determine that the ToC doesn't handle headings underneath level ```<h4>``` for example.

So a full toc shortcode could look like this: ```[toc title="My Headings" level_begin="2" level_end="4"]```

## TinyMCE

Because there are many shortcodes around in WordPress and no one can know them all it is easier to just use a button in the RTE of WordPress (TinyMCE) to generate a shortcode like **[toc]**.
 
To do so, the plugin adds an button in the first row of the TinyMCE (only on posts) which will open a dialog. In this dialog the three parameters from above can be choose and after clicking "OK" the plugin will generate the shortcode **[toc]** with the choosen parameters at the cursor position in the text.

![Shortcode dialog in TinyMCE](assets/screenshot-3.png)

## Settings

![General Settingscreen in Backend](assets/screenshot-2.png)
*more coming soon*

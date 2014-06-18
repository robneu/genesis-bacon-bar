# Genesis Bacon Bar

A free Hello Bar alternative for a any Genesis website.

__Contributors:__ [Robert Neu](https://github.com/wpbacon)  
__Requires:__ Genesis 2.0, WordPress 3.9  
__Tested up to:__ Genesis 2.1, WordPress 3.9  
__License:__ [GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.html)  

One of the most important things you need to do with on your website is call the attention of your visitors to something. The Genesis Bacon Bar makes this extremely easy by giving you the ability to add a fully-customizable, site-wide call-to-action bar. You can add your own text, choose your own colors, and even choose how and where you'd like your bacon bar to display!

## Features

* Easily add a call-to-action bar to your website without writing any code.
* Responsive design which adapts well to mobile devices.
* Customize the look and feel in real time using the WordPress customizer.
* Override bacon bar templates in a theme or child theme.
* Developer-friendly code which allows for simple style and display overrides.

## Settings

All settings are handled within the WordPress customizer interface. You can control the text, button text, link, placement, style, and colors of the bacon bar in real-time.

![Bacon Bar Content Screenshot](https://raw.github.com/wpbacon/genesis-bacon-bar/master/screenshot-1.jpg)
_The bacon bar content editor._

![Bacon Bar Style Screenshot](https://raw.github.com/wpbacon/genesis-bacon-bar/master/screenshot-2.jpg)
_The bacon bar style editor._

## Template Hierarchy

Templates can be defined in a theme or child theme to override the plugin's template. Templates must be placed inside a /genesis-bacon-bar/ directory within the theme. You can override the default templates using the following template names:

* bacon-bar.php
* bacon-bar-footer.php

## Installation ##

### Upload ###

1. Download the [latest release](https://github.com/wpbacon/genesis-bacon-bar/archive/master.zip) from GitHub.
2. Go to the __Plugins &rarr; Add New__ screen in your WordPress admin panel and click the __Upload__ tab at the top.
3. Upload the zipped archive.
4. Click the __Activate Plugin__ link after installation completes.

### Manual ###

1. Download the [latest release](https://github.com/wpbacon/genesis-bacon-bar/archive/master.zip) from GitHub.
2. Unzip the archive.
3. Copy the folder to `/wp-content/plugins/`.
4. Go to the __Plugins__ screen in your WordPress admin panel and click the __Activate__ link under GistPress.

Read the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git ###

Clone this repository in `/wp-content/plugins/`:

`git clone git@github.com:wpbacon/genesis-bacon-bar.git`

Then go to the __Plugins__ screen in your WordPress admin panel and click the __Activate__ link under GistPress.

## Updating ##

There are a couple of plugins for managing updates to GitHub-hosted plugins. Either of these should notify you when this plugin is updated:

* [Git Plugin Updates](https://github.com/brainstormmedia/git-plugin-updates)
* [GitHub Updater](https://github.com/afragen/github-updater)

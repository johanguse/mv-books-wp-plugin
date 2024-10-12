# MVUP Books WordPress Plugin

A WordPress plugin for managing and displaying books on your website.

## Table of Contents

- [MVUP Books WordPress Plugin](#mvup-books-wordpress-plugin)
  - [Table of Contents](#table-of-contents)
  - [Description](#description)
  - [Features](#features)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Development](#development)
  - [Gulp Commands](#gulp-commands)
  - [Internationalization](#internationalization)
  - [Customization](#customization)
  - [License](#license)

## Description

MVUP Books is a powerful WordPress plugin designed to help you manage and showcase books on your website. It provides an easy-to-use interface for adding, editing, and displaying book information, including covers, authors, and other metadata.

## Features

- Custom post type for books
- Book metadata management (author, ISBN, publication date, etc.)
- Shortcodes for displaying book lists and individual books
- Customizable templates for book displays
- Responsive design for optimal viewing on all devices
- Integration with popular caching plugins for improved performance

## Installation

1. Download the plugin zip file.
2. Log in to your WordPress admin panel.
3. Go to Plugins > Add New > Upload Plugin.
4. Choose the downloaded zip file and click "Install Now".
5. After installation, click "Activate Plugin".

## Usage

After activation, you'll find a new "Books" menu item in your WordPress admin panel. Use this to add and manage your books.

To display books on your site, use the following shortcodes:

- `[recent_books]` - Displays a list of all books

## Development

To set up the development environment:

1. Clone this repository to your local machine.
2. Run `npm install` on public folder to install all dependencies.
3. Use the Gulp commands listed below to compile assets and watch for changes.

## Gulp Commands

- `npm run watch`: Watches for changes in SCSS and JS files and compiles them automatically.
- `npm run styles`: Compiles SCSS files to CSS.
- `npm run scripts`: Compiles and minifies JS files.
- `npm run build`: Runs all compilation tasks (styles, scripts).
- `npm run makepot`: Creates a .pot file in the `languages/` directory.

## Internationalization

The plugin is translation-ready. Use the provided .pot file in the `languages/` directory to create translations for your language.
To create a translation, use the `npm run makepot` command. This will generate a .pot file in the `languages/` directory.

## Customization

You can customize the plugin's appearance and behavior by modifying the templates in the `public/partials/` directory and the styles in `public/src/scss/style.scss`.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
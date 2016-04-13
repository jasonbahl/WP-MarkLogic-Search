# WP-MarkLogic-Search

## Table of Contents
 - [Overview](#overview)
 - [How It Works](#how-it-works)
 - [Features](#features)
 - [Getting Help](#getting-help)
 - [Requirements](#requirement)
 - [Quickstart](#quickstart)

## Overview
This WordPress plugin adds [MarkLogic](http://www.marklogic.com/what-is-marklogic/) search to your WordPress site.  Speed up and improve accuracy of your search results by utilizing all the benfits of MarkLogic. If you manage multiple websites that are related and want to provide search against a master, centralized database on your WordPress site, this plugin can help you.

## How It Works
The plugin utilizes [MLPHP](https://github.com/marklogic/mlphp) - PHP Connector for MarkLogic REST API - to communicate with MarkLogic database.  After the plugin is installed and configured with a MarkLogic databaes instance, every time new content is created on your site - post, page, or any other content types - it is pushed to MarkLogic via REST API.  Any subsequent updates to existing content will be pushed to MarkLogic as well.

For existing content - i.e. you already have a lot of content on your site when you install this plugin - you can easily push them to MarkLogic with a click of a button.  

When a post or page is deleted, it is also deleted on MarkLogic database as well, making sure that the data is synced between your WordPress site and MarkLogic database.

## Features

### Bulk Insert
If you install this plugin on a site with existing content, you can insert them into MarkLogic in bulk.  It utilizes cron feature in WordPress so that once push button is clicked, you do not have to wait with your browser open.

### Automatic Sync
If you install this plugin on a site with existing content, you can insert them into MarkLogic in bulk.  It utilizes cron feature in WordPress so that once push button is clicked, you do not have to wait with your browser open.

### Search



## Getting Help
To get help with this plugin,

* Create [git issues](https://github.com/seongbae/WP-MarkLogic-Search/issues)
* Read up on [MLPHP](https://github.com/marklogic/mlphp)
* Check out the [MarkLogic tutorials](https://developer.marklogic.com/learn)


## Requirements
* A supported version of [MarkLogic](https://github.com/marklogic/roxy/wiki/Supported-MarkLogic-versions)
* [Ruby 1.9.3](http://www.ruby-lang.org/en/) or greater
* [Java (jdk)](http://www.oracle.com/technetwork/java/javase/downloads/index.html)
  Only if you wish to run the [mlcp](http://developer.marklogic.com/products/mlcp), [XQSync](http://developer.marklogic.com/code/xqsync, XQSync), or [RecordLoader](http://developer.marklogic.com/code/recordloader) commands.
* [Git](http://git-scm.com/downloads) - Required to create a new project using "ml new".

## Quick Start
Coming soon...



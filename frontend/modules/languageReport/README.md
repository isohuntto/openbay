# Language report module

Language report is a module designed for [The Open Pirate Bay](https://oldpiratebay.org/100k)
to give user an opportunity to vote for content language.

## Dependencies
The module depends on the following components:
 - yiisoft/yii2
 - yiisoft/yii2-bootstrap
 - bower-asset/tagsinput
 - bower-asset/typeahead.js

## Installation
 1. Checkout branch with the module.
 2. Run **composer update**.
 3. Apply migrations with *yii migrate --migrationPath=@frontend/modules/languageReport/migrations*.
 4. You may copy module view file to *@themes/theme_name/modules/languageReport/* and rewrite it to design your own theme.

## Openbay core injections
1. Adds module record to **main-local.php**
2. Adds i18n record to **frontend/main.php**
3. Adds widget to **@frontend/themes/newopb/modules/torrent/views/default/view.php**

## Usage
Now the widget is displayed on torrent view page. Any registered user can select
language for torrent. When user starts typing language *typeahead.js* helps user to type.
After sending report to server the content languages are replaced with calculated ones.

## Improvements
At the moment languages are stored in separate table to decrease number of injection to core code.
It can be either replaced by field in *torrents* table or joined with *tags* field in *torrents* table,
handling the **EVENT_LANGUAGEREPORT_ADD** event.

When the list of added languages grows, it can be filtered using *confirmed* field in *language* table.
This field indicates how many users had selected the language.

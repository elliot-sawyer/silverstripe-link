# Silverstripe link

[![ko-fi](https://www.ko-fi.com/img/donate_sm.png)](https://ko-fi.com/E1E5HWRR)

Adds a Link Object that can be link to a URL, Email, Phone number, an internal Page or File.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require gorriecoe/silverstripe-link
```

## Requirements

- silverstripe/framework ^4.0
- unclecheese/display-logic ^2.0
- giggsey/libphonenumber-for-php ^8.0

## Suggestion

- [gorriecoe/silverstripe-linkfield](https://github.com/gorriecoe/silverstripe-linkfield). Silverstripe link opts to separated from linkfield to give the opportunity for developers to choose their own relationship manager such as gridfield.  I'm happy to add any other suggested modules to this list.
- [gorriecoe/silverstripe-logoutlink](https://github.com/gorriecoe/silverstripe-logoutlink)

## Embed

If you are coming from [Linkable](https://github.com/sheadawson/silverstripe-linkable) and are looking for Embed functionality check out [silverstripe-embed](https://github.com/gorriecoe/silverstripe-embed)

## Maintainers

- [Gorrie Coe](https://github.com/gorriecoe)

## Usage

```php
<?php

use gorriecoe\Link\Models\Link;

class MyClass extends DataObject
{
    // Option 1: Use as single element
    private static $has_one = [
        'Button' => Link::class
    ];
    
    // Option 2: Use as many elements exclusive to this record.
    // See "Usage with has_many below"
    private static $has_many = [
        'Buttons' => Link::class
    ];

    // Option 3: Use as many elements shared with other records
    private static $many_many = [
        'Buttons' => Link::class
    ];

    private static $many_many_extraFields = [
        'Buttons' => [
            'Sort' => 'Int' // Required for all many_many relationships
        ]
    ];
}
```

### Usage with has_many

Since links rely on sorting, they need a `Sort` column.
For `many_many` relationships, this can be defined on `many_many_extraFields`.
On a `has_many`, the `Link` type needs to store the sorting information directly.
You can achieve this by adding the following extension to `Link`:

```yaml
gorriecoe\Link\Models\Link:
  extensions:
    - gorriecoe\Link\Extensions\SortableLink
```

### Template options

Basic usage

```html
<% loop Links %>
    {$Me}
<% end_loop %>
```

Define link classes
```html
<% loop Links %>
    {$setClass('button')}
<% end_loop %>
```

Define a custom template to render the link

```html
<% loop Links %>
    {$renderWith('Link_button')}
<% end_loop %>
```

Define a custom style.  This will apply a css class and render a custom template if it exists.  The example below will look for Link_button.ss in the includes directory.

```html
<% loop Links %>
    {$setStyle('button')}
<% end_loop %>
```

Custom template

```html
<% loop Links %>
    <% if LinkURL %>
        <a href="{$LinkURL}"{$TargetAttr}{$ClassAttr}>
            {$Title}
        </a>
    <% end_if %>
<% end_loop %>
```

### Template variables
#### $LinkURL
Returns the URL of the link.
#### $TargetAttr
Returns the html target attribute. `target='_blank'` or `null`
#### $Target
Returns the html target attribute value. `_blank` or `null`
#### $IDAttr
Returns the html id attribute. `id='my-custom-id'` or `null`
#### $IDValue
Returns the html id value.

Refer to [Add html id attribute](https://github.com/gorriecoe/silverstripe-link#add-html-id-attribute) for more information

#### $ClassAttr
Returns the html class attribute. `class='my-custom-id'` or `null`
#### $Class
Returns the html class value.

Refer to [CMS Selectable Style](https://github.com/gorriecoe/silverstripe-link#cms-selectable-style) for more information

#### Linking Modes
Linking mode variables are also available any sitetree link.
Refer to [Linking Modes](https://docs.silverstripe.org/en/4/developer_guides/templates/common_variables/#linking-modes) for more information

### CMS Selectable Style

You can offer CMS users the ability to select from a list of styles, allowing them to choose how their Link should be rendered. To enable this feature, register them in your site config.yml file as below.

```yaml
gorriecoe\Link\Models\Link:
  styles:
    button: Description of button template # applies button class and looks for Link_button.ss template
    iconbutton: Description of iconbutton template # applies iconbutton class and looks for Link_iconbutton.ss template
```

### Limit allowed Link types

To limit types define them in your site config.yml file as below.

```yaml
gorriecoe\Link\Models\Link:
  allowed_types:
    - URL
    - SiteTree
```

### Add html id attribute

Link has 3 options for defining html id, automatic, define-able or both.

To apply automatic id's add the following to your config.
```yaml
gorriecoe\Link\Models\Link:
  extensions:
    - gorriecoe\Link\Extensions\AutomaticMarkupID
```

To apply input defineable id's add the following to your config.
```yaml
gorriecoe\Link\Models\Link:
  extensions:
    - gorriecoe\Link\Extensions\DefineableMarkupID
```

To apply both automatic and define-able add the following to your config,
ensuring the order is correct
```yaml
gorriecoe\Link\Models\Link:
  extensions:
    - gorriecoe\Link\Extensions\AutomaticMarkupID
    - gorriecoe\Link\Extensions\DefineableMarkupID
```

### String template manipulation
Link has a few methods to help manipulate DBString's.

##### PhoneFriendly
Converts a string to a phone number e.g 0800PIZZAHUT becomes 080074992488.

PHP
```php
$this->obj('Phone')->PhoneFriendly()
```
Template
```
{$Phone.PhoneFriendly}

```

Additional methods are available to modify the output of phone numbers.
```
{$Phone.PhoneFriendly.E164} = +6480074992488
{$Phone.PhoneFriendly.National} = 80074992488
{$Phone.PhoneFriendly.International} = +64 80074992488
{$Phone.PhoneFriendly.RFC3966} = tel:+64-80074992488
```

Define the country the user is dialing from
```
{$Phone.PhoneFriendly.From('GB')}
```
Define the country the phone belongs to.
```
{$Phone.PhoneFriendly.To('NZ')}
```
And define both to and from.
```
{$Phone.PhoneFriendly.From('GB').To('NZ')} or {$Phone.PhoneFriendly.To('NZ').From('GB')}
```

For more information check put https://github.com/giggsey/libphonenumber-for-php

##### LinkFriendly or URLFriendly
Converts a DBString to a url safe string.  This can be useful for anchors.

PHP
```php
$this->obj('Title')->LinkFriendly()
```
Template
```
{$Title.LinkFriendly}
```

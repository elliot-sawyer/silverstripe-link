# Silverstripe link
Adds a Link Object that can be link to a URL, Email, Phone number, an internal Page or File.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require gorriecoe/silverstripe-link
```

## Requirements

- silverstripe/framework ^4.0
- unclecheese/display-logic ^2.0

## Maintainers

- [Gorrie Coe](https://github.com/gorriecoe)

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

### CMS Selectable Style

You can offer CMS users the ability to select from a list of styles, allowing them to choose how their Link should be rendered. To enable this feature, register them in your site config.yml file as below.

```yaml
gorriecoe\Link\Models\Link:
  styles:
    button: Description of button template # applies button class and looks for Link_button.ss template
    iconbutton: Description of iconbutton template # applies iconbutton class and looks for Link_iconbutton.ss template
```

### Limit allowed Link types

Globally limit link types.  To limit types define them in your site config.yml file as below.

```yaml
gorriecoe\Link\Models\Link:
  allowed_types:
    - URL
    - SiteTree
```

### Add html id attribute

Link has 3 options for defining html id, automatic, define-able or both.

To apply automatic id's add the following to your config
```yaml
gorriecoe\Link\Models\Link:
  extensions:
    - gorriecoe\Link\Extensions\AutomaticMarkupID
```

To apply automatic id's add the following to your config
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

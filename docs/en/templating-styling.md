---
title: Templating and styling
---

## Basic usage

```html
<% loop Links %>
    {$Me}
<% end_loop %>
```

## Define link classes

```html
<% loop Links %>
    {$addExtraClass('button')}
<% end_loop %>
```
or
```html
<% loop Links %>
    {$setClass('button')}
<% end_loop %>
```

## Define a custom template to render the link

```html
<% loop Links %>
    {$renderWith('Link_button')}
<% end_loop %>
```

## Define a custom style.

This will apply a css class and render a custom template if it exists.  The example below will look for Link_button.ss in the includes directory.

```html
<% loop Links %>
    {$setStyle('button')}
<% end_loop %>
```

## Custom template

```html
<% loop Links %>
    <% if LinkURL %>
        <a href="{$LinkURL}"{$TargetAttr}{$ClassAttr}>
            {$Title}
        </a>
    <% end_if %>
<% end_loop %>
```

## Template variables

### $LinkURL

Returns the URL of the link.

### $TargetAttr

Returns the html target attribute. `target='_blank'` or `null`

### $Target

Returns the html target attribute value. `_blank` or `null`

### $IDAttr

Returns the html id attribute. `id='my-custom-id'` or `null`

### $IDValue

Returns the html id value.

Refer to [Add html id attribute](https://github.com/gorriecoe/silverstripe-link#add-html-id-attribute) for more information

### $ClassAttr

Returns the html class attribute. `class='my-custom-id'` or `null`

### $Class

Returns the html class value.

Refer to [CMS Selectable Style](https://github.com/gorriecoe/silverstripe-link#cms-selectable-style) for more information

### Linking Modes

Linking mode variables are also available any sitetree link.
Refer to [Linking Modes](https://docs.silverstripe.org/en/4/developer_guides/templates/common_variables/#linking-modes) for more information

## Define a custom style via the template

This will apply a css class and render a custom template if it exists.  The example below will look for Link_button.ss in the includes directory.

```html
<% loop Links %>
    {$setStyle('button')}
<% end_loop %>
```

## CMS Selectable styles / style variants

You can offer CMS users the ability to select from a list of styles, allowing them to choose how their Link should be rendered. To enable this feature, register them in your site config.yml file as below:

```yaml
gorriecoe\Link\Models\Link:
  styles:
    button: Description of button template # applies button class and looks for Link_button.ss template
    iconbutton: Description of iconbutton template # applies iconbutton class and looks for Link_iconbutton.ss template
```

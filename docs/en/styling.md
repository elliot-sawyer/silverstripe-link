---
title: Styling
---

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

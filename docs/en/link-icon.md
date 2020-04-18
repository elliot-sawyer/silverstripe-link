---
title: Link icon
---

## Installation

To add icons to links you can either make your own [extension](extending) or install [silverstripe-linkicon](https://github.com/gorriecoe/silverstripe-linkicon) with the following:

```
composer require gorriecoe/silverstripe-linkicon
```

## Template

Add `$Icon` to your `Link.ss` file.
```
<% if LinkURL %>
    <a{$IDAttr}{$ClassAttr} href="{$LinkURL}"{$TargetAttr}>
        {$Icon}{$Title}
    </a>
<% end_if %>
```

### Options

#### Define folder

Define folder to store the icons assets into.

```yml
gorriecoe\Link\Models\Link:
  icon_asset_folder: 'SomeFolderName' // Defaults to 'Icons'
```

#### Define tab

Defines tab to insert the icon_folder fields into.

```yml
gorriecoe\Link\Models\Link:
  icon_tab: 'SomeTabName' // Defaults to 'Settings'
```

#### Define allowed file extensions

Defines the allowed file extensions for the icon field.

```yml
gorriecoe\Link\Models\Link:
  icon_allowed_extensions:
    - 'gif'
    - 'jpeg'
    - 'jpg'
    - 'png'
    - 'bmp'
    - 'ico'
```

## Link icon only

Below is step by step instructions to setup icon only links.

```
composer require gorriecoe/silverstripe-linkicon
```

In your config.yml add the following:

```yml
gorriecoe\Link\Models\Link:
  styles:
    icononly: Icon only
```

Create a `Link_icononly.ss` file in your theme includes directory with the following:

```
<% if LinkURL %>
    <a{$IDAttr}{$ClassAttr} href="{$LinkURL}"{$TargetAttr}>
        <img src="{$Icon.Link}" alt="{$Title}" />
    </a>
<% end_if %>
```

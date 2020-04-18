---
title: Link Icon
---

## Link icon only

Step by step instructions to setup link icon.

```
composer require gorriecoe/silverstripe-link gorriecoe/silverstripe-linkicon
```

In your config.yml add the following:

```yml
gorriecoe\Link\Models\Link:
  icon_asset_folder: 'SomeFolderName' // Defaults to 'Icons'
  icon_tab: 'SomeTabName' // Defaults to 'Settings'
```

Create a `Link.ss` file in your theme includes directory with the following:

```
<% if LinkURL %>
    <a{$IDAttr}{$ClassAttr} href="{$LinkURL}"{$TargetAttr}>
        {$Icon}{$Title}
    </a>
<% end_if %>
```

## Link icon only

Step by step instructions to setup icon only links.

```
composer require gorriecoe/silverstripe-link gorriecoe/silverstripe-linkicon
```

In your config.yml add the following:

```yml
gorriecoe\Link\Models\Link:
  icon_asset_folder: 'SomeFolderName' // Defaults to 'Icons'
  icon_tab: 'SomeTabName' // Defaults to 'Settings'
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

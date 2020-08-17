---
title: Link types
---

Link has few types built in.  URL, Email, Phone number, an internal Page or File.

## Default link types

The default types available are:

```yaml
URL: URL
Email: Email address
Phone: Phone number
File: File on this website
SiteTree: Page on this website
```

## Limit allowed link types

To limit types define them in your site config.yml file as below.

```yaml
gorriecoe\Link\Models\Link:
  allowed_types:
    - URL
    - SiteTree
```

## Allow linking to folders

By default, when the type is set to "File", folders cannot be selected.
If you want to be able to link to folders, add the following in your site config.yml file:

```yaml
gorriecoe\Link\Models\Link:
  link_to_folders: true
```

## Adding custom link types

To add custom link types refer to [Adding custom link types](extending#adding-custom-link-types)

## Preset link types

To add preset link types you can install [silverstripe-ymlpresetlinks](https://github.com/gorriecoe/silverstripe-ymlpresetlinks):

```
composer require gorriecoe/silverstripe-ymlpresetlinks
```

Then in your config.yml apply the following examples;

```yml
gorriecoe\Link\Models\Link:
  preset_types:
    'hello-world':
      Title: "Hello world alert"
      LinkURL: "javascript:alert('Hello World!');"
    'back-to-top':
      Title: "Scroll to top"
      LinkURL: "#back-to-top"
    'google':
      Title: "Google"
      LinkURL: "https://www.google.com/"
      OpenInNewWindow: true
```

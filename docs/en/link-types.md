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

## Limit allowed Link types

To limit types define them in your site config.yml file as below.

```yaml
gorriecoe\Link\Models\Link:
  allowed_types:
    - URL
    - SiteTree
```

## Adding custom link types

To add custom linnk types refer to [Adding custom link types](extending#adding-custom-link-types)

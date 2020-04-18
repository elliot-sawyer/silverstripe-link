---
title: Silverstripe link
---

# Installation

## Requirements

-   [silverstripe/framework](enhttps://github.com/silverstripe/silverstripe-framework) ^4.0
-   [unclecheese/display-logic](https://github.com/unclecheese/silverstripe-display-logic) ^2.0
-   [giggsey/libphonenumber-for-php](https://github.com/giggsey/libphonenumber-for-php) ^8.0

## Installing silverstripe link

First download the silverstripe link using Composer in your project root:

```
composer require gorriecoe/silverstripe-link
```

### Migration

If you are migrating from [Linkable](https://github.com/sheadawson/silverstripe-linkable) checkout [Link migrator](https://github.com/dynamic/silverstripe-link-migrator) from dynamic.

## Contents

-   [Usage](usage)
-   [Templating](templating)
-   [Styling](styling)
-   [Html ID attribute](html-ID)
-   [Add an icon](link-icon)
-   [DBString manipulation](string-manipulation)
-   [Phone number output](string-manipulation#phonefriendly)
-   [Link/anchor friendly output](string-manipulation#linkfriendly)
-   [Extending](extending)
-   [Embed](#embed)
-   [Other module suggestions](#other-module-suggestions)

### Embed

If you are coming from [Linkable](https://github.com/sheadawson/silverstripe-linkable) and are looking for Embed functionality check out [silverstripe-embed](https://github.com/gorriecoe/silverstripe-embed)

### Other module suggestions

-   [gorriecoe/silverstripe-linkfield](https://github.com/gorriecoe/silverstripe-linkfield).
-   [silvershop/silverstripe-hasonefield](https://github.com/silvershop/silverstripe-hasonefield).
-   [gorriecoe/silverstripe-menu](https://github.com/gorriecoe/silverstripe-menu). Adds multiple menus that are defined via yml and managed via the cms.
-   [nglasl/silverstripe-misdirection](https://github.com/nglasl/silverstripe-misdirection).  Allows both simple and regular expression link redirections based on customisable mappings, either hooking into a page not found or replacing the default automated URL handling.
-   [gorriecoe/silverstripe-securitylinks](https://github.com/gorriecoe/silverstripe-securitylinks). Add security link types
-   [gorriecoe/silverstripe-directionslink](https://github.com/gorriecoe/silverstripe-directionslink). Add directions link type
-   [gorriecoe/silverstripe-advancedemaillinks](https://github.com/gorriecoe/silverstripe-advancedemaillinks). Add additional email options to email type
-   [gorriecoe/silverstripe-linkicon](https://github.com/gorriecoe/silverstripe-linkicon). Add an icon to link output

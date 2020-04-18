---
title: Html ID attribute
---

## Add html id attribute

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

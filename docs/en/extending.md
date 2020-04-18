---
title: Extending
---

## Adding custom link types

Sometimes you might have custom DataObject types that you would like CMS users to be able to create Links to. This can be achieved by adding a DataExtension to the Link DataObject, see the below example for making Product objects Linkable.

```php

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class CustomLinkExtension extends DataExtension
{
    private static $has_one = [
        'Product' => 'Product',
    ];

    private static $types = [
        'Product' => 'A Product on this site',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        // Add a dropdown field containing your ProductList
        $fields->addFieldToTab(
            'Root.Main',
            Wrapper::create(
                DropdownField::create(
                    'ProductID',
                    'Product',
                    Product::get()->map('ID', 'Title')->toArray()
                )
                ->setHasEmptyDefault(true)
            )->displayIf('Type')->isEqualTo('Product')->end()
        );
    }
```

In your config.yml

```yml
gorriecoe\Link\Models\Link:
  extensions:
    - CustomLinkExtension
```

## Working examples

The following modules enhance link but can also be used as working examples for what is possible.

-   [Add security link types](https://github.com/gorriecoe/silverstripe-securitylinks)
-   [Add directions link type](https://github.com/gorriecoe/silverstripe-directionslink)
-   [Add additional email options to email type](https://github.com/gorriecoe/silverstripe-advancedemaillinks)
-   [Add an icon to link output](https://github.com/gorriecoe/silverstripe-linkicon)

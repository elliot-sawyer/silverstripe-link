---
title: Usage
---

## Has one example

For the example below you will need to install [linkfield](https://github.com/gorriecoe/silverstripe-linkfield)

```sh
composer require gorriecoe/silverstripe-linkfield
```

```php
<?php

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;

class MyClass extends DataObject
{
    private static $has_one = [
        'Button' => Link::class
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create(
                    'Button',
                    'Button',
                    $this

            ]
        );
        return $fields;
    }
}
```

## Many many example

For the example below you will need to install [linkfield](https://github.com/gorriecoe/silverstripe-linkfield)

```sh
composer require gorriecoe/silverstripe-linkfield
```

```php
<?php

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;

class MyClass extends DataObject
{
    private static $many_many = [
        'Buttons' => Link::class
    ];

    private static $many_many_extraFields = [
        'Buttons' => [
            'Sort' => 'Int' // Required for all many_many relationships
        ]
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create(
                    'Buttons',
                    'Buttons',
                    $this
                )
            ]
        );
        return $fields;
    }
}
```


## Has many example

Although it is possible to add a has many relationship it is *NOT* recommmended.

For the example below you will need to install [linkfield](https://github.com/gorriecoe/silverstripe-linkfield)

```sh
composer require gorriecoe/silverstripe-linkfield
```

```php
<?php

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;

class MyClass extends DataObject
{
    private static $has_many = [
        'Buttons' => Link::class
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create(
                    'Buttons',
                    'Buttons',
                    $this
                )
            ]
        );
        return $fields;
    }
}
```

In your config.yml

```yml
gorriecoe\Link\Models\Link:
  db:
    Sort: Int
```

---
title: String manipulation
---

## String template manipulation

Link has a few methods to help manipulate DBString's.

### PhoneFriendly

The method `PhoneFriendly` converts a string to a phone number e.g 0800PIZZAHUT becomes 080074992488.

PHP

```php
$this->obj('Phone')->PhoneFriendly()
```

Template
```html
{$Phone.PhoneFriendly}
```

Additional methods are available to modify the output of phone numbers.
```html
{$Phone.PhoneFriendly.E164} = +6480074992488
{$Phone.PhoneFriendly.National} = 80074992488
{$Phone.PhoneFriendly.International} = +64 80074992488
{$Phone.PhoneFriendly.RFC3966} = tel:+64-80074992488
```

#### Define the country the user is dialing from

```html
{$Phone.PhoneFriendly.From('GB')}
```

#### Define the country the phone belongs to.

```html
{$Phone.PhoneFriendly.To('NZ')}
```

#### Define both to and from.

```html
{$Phone.PhoneFriendly.From('GB').To('NZ')} or {$Phone.PhoneFriendly.To('NZ').From('GB')}
```

For more information check put <https://github.com/giggsey/libphonenumber-for-php>

### LinkFriendly

Converts a DBString to a url safe string.  This can be useful for anchors.

PHP

```php
$this->obj('Title')->LinkFriendly()
// or
$this->obj('Title')->URLFriendly()
```

Template

```html
{$Title.LinkFriendly}
<!-- or -->
{$Title.URLFriendly}
```

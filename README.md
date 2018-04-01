# PHP library for searching phones from a some string

### Simple example
```php
$string = '8898-2984982  +778553108-68 dfdsf +778553108-68 ddfsdsfd +758453-108-68';
$matcher = new Matcher('RU');
return $matcher->findNumbers($string);

```
resulted

```json
[
    "88982984982",
    "87855310868",
    "85845310868"
]
```
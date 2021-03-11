# Model Traits

---

- [ActiveScopes](#active-scopes)
- [HasUniqueColumns](#has-unique-columns)
- [OrderByScopes](#order-by-scopes)

<a name="active-scopes"></a>
## ActiveScopes

This trait adds two scopes to your mode: `active()` and `inactive()`.  As they suggest, they query that the `activeFlag` 
column on your model is `1` or `0` respectively.

<a name="has-unique-columns"></a>
## HasUniqueColumns

This trait is used to make sure that any column in the `$uniqueStringColumns` array has unique strings.  It will generate 
a string using Laravel's `Str::random()` with the limit you set with `$uniqueStringLimit`.  It then checks that the column 
in question does not somehow already have that string.  If it does, it will generate a new one until it is unique.

To use this trait, make sure you add the following properties to your model.

```php
/**
 * Any field in this array will be populated with a unique string on create.
 *
 * @var array
 */
protected static $uniqueStringColumns = [];

/**
 * The size string to generate for unique string column.
 *
 * @var int
 */
protected static $uniqueStringLimit = 10;
```

<a name="order-by-scopes"></a>
## OrderByScopes

This trait ads 4 new scopes to your model.  the order by scopes use the `created_at` column while the name scopes use the 
`name` column.

1. `orderByCreatedAsc()`
1. `orderByCreatedDesc()`
1. `orderByNameAsc()`
1. `orderByNameDesc()`

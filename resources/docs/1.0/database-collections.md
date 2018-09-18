# Collections

---

- [Tap a property of a collection](#tap-property-of-collection)
- [Run method on collection](#run-method-on-collection)
- [Searching a collection](#searching-collection)
- [Method name convention](#method-name-convention)
- [Method parameters](#method-parameters)
- [Method Modifiers](#method-modifiers)
- [Example](#example)

<a name="tap-property-of-collection"></a>
## Tap a property of a collection

If you have a collection you can tap a relationship of an object in the collection to get a new collection of the relationship 
data. You can also tap a property of the object in the collection to get a new collection of all instances of that property 
in that collection.

```php
$users = User::all();
$actions = $users->roles->actions;
$roleNames = $users->roles->name;
```
  
In this example, $actions would return a collection of all actions attached to all roles attached to the users.
`$roleNames` would return a collection of every role name for each role the users are attached to.

<a name="run-method-on-collection"></a>
## Run method on collection

You can run a method on the entire collection such as `save()`, or `delete()`.  If you wanted to delete an entire 
collection you could do
```php
$users->roles->delete();
```
  
<a name="searching-collection"></a>
## Searching a collection

If you need to return a specific set of objects from a collection you can call the `getWhere()` method on the collection. 
This is a magic method used to search the collection.  Get where can take several extra parameters by changing the method name.

<a name="method-name-convention"></a>
### Method name convention

getWhere[ in | between | like | null | many ] [not] [ first | last ](mixed $column, mixes $value)

<a name="method-parameters"></a>
### Method parameters

Method Name | Parameters |Result
----------- | ---------- | --------
getWhere         | STRING $column<br />STRING $value            | This will return all object in the collection that have the column `$column` that equals `$value`.
getWhereIn       | STRING $column<br />STRING $values            | This will return all objects in the collection where the column `$column` is in the array of `$values`.
getWhereBetween  | STRING $column<br />STRING $values            | This will return all objects in the collection where the column `$column` is between `$values[0]` and `$values[1]`.
getWhereLike     | STRING $column<br />STRING $value            | This will return all objects in the collection where column `$column` contains the sub string `$value`.
getWhereNull     | STRING $column            | This will return all objects in the collection where column `$column` is null.
getWhereMany     | ARRAY $columns => $values | This will return all objects in the collection that match all where statements in the passed in array.

<a name="method-modifiers"></a>
### Method Modifiers

Method Name | Parameters |Result
----------- | ---------- | --------
getWhereNot      | STRING $column<br />STRING $value          | This will return all objects in the collection that column `$column` is other than $value.  (The not operator can be added to all methods to invert the results)
getWhereFirst    | STRING $column<br />STRING $value          | This will return only the first object in the collection.  (The first operator can be added to all methods to return the first result)
getWhereLast     | STRING $column<br />STRING $value          | This will return only the last object in the collection.  (The last operator can be added to all methods to return the last result)

<a name="example"></a>
### Example

You can also look at `the tests <https://github.com/NukaSRB/Core/blob/master/tests/spec/JumpGate/Core/Database/CollectionSpec.php>`_ for more examples
```php
$aColleciton->getWhere('aField','Some Text');
$aCollection->getWhere('relationship->aField', 'Some Text');
$aCollection->getWhereNot('relationship->aField', 'Some Text');
```

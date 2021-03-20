# Helper Classes

---

- [BaseModel](#base-model)
- [BaseRepository](#base-repository)
- [Traits](#traits)

<a name="base-model"></a>
## BaseModel

The BaseModel class is used by all JumpGate models.  You can remove this by changing what your local BaseModel extends or 
by setting `public $jumpGateCollections` to false in your models.

You can also set the `protected static $observer` property to an observer for your model and it will be automatically registered 
for you in the `boot()` method.

> {info} You can learn more about Laravel model observers on [their docs](https://laravel.com/docs/8.x/eloquent#observers).

<a name="base-repository"></a>
## BaseRepository

The BaseRepository is an abstract class meant to handle some of the common methods repositories could need.  This includes 
`find($id)`, `findFirst($id)`, `orderByName()`, and `paginate($count)`.  It also has a magic call to try to find what you 
might be calling locally or on the model.

<a name="traits"></a>
## Traits

This package comes with quite a few collections.  You can look into the ones below to get more details on the specific methods
they offer.

### Collections
All of these traits are included in both `SupportCollector` and `EloquentCollector` classes.

<br />
#### Chaining
This trait adds the ability to tap through items, call methods on all items in a collection and tap through items.

<br />
#### Helpers
This traits gives collections the ability to parse from any starting point and also explode a string directly into an 
array.

<br />
#### Searching
This trait adds all of our nice getWhere helpers to collections.  You can see more details on this on the 
[collections page](/docs/{{version}}/database/collections#searching-collection) page.

### Models

The ActiveScopes and OrderByScopes traits are included by default on BaseModel.  You can get details on the model traits 
at the [Model Traits doc](/docs/{{version}}/database/traits).

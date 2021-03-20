# RBAC - Permission System

---

- [Introduction](#introduction)
- [LaraTrust](#laratrust)

<a name="introduction"></a>
## Introduction

We used to manage our own RBAC for this package, but over time we have looked at other options.  Currently, our favorite 
package that has worked out is LaraTrust.  We have even done some pull requests to their code to add better customization 
options.

<a name="laratrust"></a>
## LaraTrust

For our permission handling we use LaraTrust.  We have not made ny modifications to the basic set up other than the following 
bits.

1. We have switched the returned collections for roles and permissions to JumpGate EloquentCollections
1. We have prepended the table names with `rbac_` so that they are all grouped in the database.

Other than this, we completely follow LaraTrust.  Look to [their docs](https://laratrust.santigarcor.me/docs/6.x/) for 
anything you need to do.

# JumpGate Code Style Guide

---

- [Introduction](#introduction)
- [PSR-1 and PSR-12](#psr)
- [Additions to PSR](#additions-to-psr)
- [Naming Convention](#naming-convention)
- [Controllers](#controllers)
- [Services](#services)

<a name="introduction"></a>
## Introduction

The goal of this guide is to create a unified set of code style rules that all JumpGate packages follow.  If you want to use 
these for your app as well feel free.  If you have different guidelines modify this document to suit your needs.

<a name="psr"></a>
## PSR-1 and PSR-12

To begin with, we MUST follow PHP's PSR-1 and PSR-12.  These two PHP-FIG standards are always in effect and followed.  At 
times we may add extra details to something that is avoided by these, but if it's mentioned in them, we will follow.  You 
can add PSR-2 code sniffing to your IDE to make sure you are always consistent.

- [PSR-1](https://www.php-fig.org/psr/psr-1/)
- [PSR-12](https://www.php-fig.org/psr/psr-12/)
- [Setting it up in your editor](/docs/{{version}}/basics/enforcing-psr-2)

<a name="additions-to-psr"></a>
## Additions to PSR

Now, we will specify some things that we consider important that are not covered by PSR standards.

<a name="naming-conventions"></a>
## Naming Convention

These are areas in the code where we feel there should be accepted conventions and conformity.

1. Route prefixes SHOULD ALWAYS be singular.
    1. This solves the confusion of some being plural and some being singular. By using singular you avoid the problem of 
    some being just an `s` and some being `ies`.
1. Route names SHOULD BE singular.
    1. For example, if your service is called `Announcing` your route names should all begin with `announcement`.
1. Route names SHOULD ALWAYS begin with their prefix when it's not `default`.
    1. For example, if your in the `admin` context your route name should begin with `admin`.
1. Classes performing a specific function MUST NOT contain the function word in their name.
    1. Examples:
        1. Files in the `app/Http/Controllers` directory MUST NOT have the word `Controller` in their name.
        1. Interface files MUST NOT contain the word `Interface` in their name.
    1. The folder or class type does a perfect job of explaining what the object is.
    
<a name="controllers"></a>
## Controllers

Here are a few specific rules for controllers.

1. When the controller is in the base (`app/Http/Controllers`) directory, it MAY contain the word `controller`.
1. Controller names MUST be singular.
1. You SHOULD TRY to only the standard 7 resourceful actions on a controller.
    1. If you can;t fit what you need to do in the following actions, you may need a new controller.
        1. Index
        1. Show
        1. Create
        1. Store
        1. Edit
        1. Update
        1. Destroy
    1. [This is a great video](https://www.youtube.com/watch?v=MF0jFKvS4SI) on this subject.
    
<a name="services"></a>
## Services

For consistency the following rules should be observed.

1. You MUST name your service as a verb when possible.
    1. `Incentivizing` instead of `Incentives`.
1. You SHOULD NOT add the type of class to the name.
    1. The Incentive controller should be called `Incentive` and not `IncentiveController`.
1. You MUST use singular names for your controllers.
    1. `Incentive` and not `Incentives`.
1. You MUST keep resource route names singular.
    1. This is for consistency and to avoid confusion in spelling.

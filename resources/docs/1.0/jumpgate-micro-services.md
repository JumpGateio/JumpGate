# Micro Services

---

- [Introduction](#introduction)
- [Set Up Manually](#set-up-manually)
- [Naming Conventions](#naming-conventions)
 
<a name="introduction"></a>
## Introduction

Micro-service architecture is a name we have given to our newest way of organizing code.  The concept here is to break up 
the app into services.  Each service should contain all of its own needs such as models, controllers, routes, events, 
etc.  The service will end up looking like a miniature app or a small package in the end, and this is what we are wanting 
to see.  The benefits of this are that all the code you need for the service is inside a single directory and easy to 
find.

<a name="set-up-manually"></a>
### Set Up Manually

To begin with services, create a `Services` folder in your `app` directory if one doesn't exist already.  Inside that folder 
you should place any of the following folders you may need.

```bash
- Commands
- Contracts
- Events
- Http
    - Controllers
    - Routes
- Jobs
- Listeners
- Models
- Repositories
- Transformers
```

Events, Http, Http/Controllers, Listeners and Models all behave exactly the same as their app level counterparts.  Commands 
is where you would place any commands.  These are the special jobs we have that are fired and forgotten about using 
the `command()` helper.  Contracts would be where you place all of your interface files.  Http/Routes is the location for 
your class based routes.  Repositories would be where repositories go should you need them.  Transformers is the location 
of the transformer files used to make sure the view and vue files have consistent data at all times.  These could also be 
used for APIs.

<a name="naming-conventions"></a>
## Naming Conventions

You can find our naming convention on micro services in the [code style guide](/docs/{{version}}/jumpgate-code-style#services).

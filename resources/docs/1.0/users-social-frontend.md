# Social How-To

---

- [Linking](#linking)

<a name="linking"></a>
## Linking

> {info} This section assumes you have set up your providers as detailed in [providers](/docs/{version}/users-social-providers).

In order to have a user authenticate against one of your drivers, all you need to do is a link similar to the example below.

```html
    <a href="{ { route('auth.social.login', ['google']) }}">Log in with Google</a>
    <a href="{ { route('auth.social.login', ['github']) }}">Log in with Github</a>
```

The route name will never change, just replace the string in the array with your provider as detailed in 
`config/jumpgate/users.php`.  This will automatically send them off to be authenticated.

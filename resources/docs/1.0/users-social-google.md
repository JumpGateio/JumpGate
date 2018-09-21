# Google API Key Generation

---

> {info} This doc was added since google is a common choice for authentication but is not the easiest to figure out.

To set up the google API (which we use for authentication), just follow these steps.

1. Go to the [Google API Console](https://console.developers.google.com/apis?pli=1).
1. Click on the drop down to the right of "`Google APIs`".
1. Click the "`New Project`" button on the top right of the modal.
1. Give the project a name you will easily recognize.  I used `[PROJECT] - Local`.
    1. By this example I mean that I set the name to `<My Project>` and then the environment the key will be for.
1. Wait a bit for google to finish generating your project.
    1. You will know it is done by clicking on the drop down again.  If it is not there, it's still being created.
1. Once it is done click on it.
1. Click "`Credentials`" on the left hand side.
1. Click on "`OAuth consent screen`".
1. Fill out these details.
    1. Product name: "[PROJECT] - Local"
    1. Everything else is either pre-filled or can be left empty.
1. Click "`Save`".
1. The page should redirect to "`Create OAuth client ID`".
    1. If it doesn't, use these steps to get there.
        1. Go to "`Credentials`".
        1. Click "`Create credentials`".
        1. Select "`OAuth client ID`".
1. Fill out the form.
    1. Web application
    1. Name: anything
    1. Authorized JavaScript origins: empty
    1. Authorized redirect URIs: [your local site]/callback/google
        1. For example, mine was: http://[PROJECT].dev/callback/google
1. Add the client ID and client secret you are given to your `.env`.
    1. `GOOGLE_KEY=` is where you put your client ID.
    1. `GOOGLE_SECRET=` is where you put your client secret.
    1. `GOOGLE_REDIRECT_URI=` should be the same as the `Authorized redirect URI` you gave the previous page.
1. Back in google console, click "`Library`" on the left.
1. Type "`Google+`" into the search and select "`Google+ API`".
1. Click "`ENABLE`"
1. That's it!

**For easy copying into your `.env`**
```php
GOOGLE_KEY=
GOOGLE_SECRET=
GOOGLE_REDIRECT_URI=
```

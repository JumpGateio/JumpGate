# Built Ins

---

- [Introduction](#introduction)
- [Shared Data](#shared-data)
- [Forms](#forms)
- [Packages](#packages)

<a name="introduction"></a>
## Introduction

JumpGate does a few common things for you when it comes to inertia.  Aside from the auto resolving route -> page file, 
it also passes some common data to inertia for you.

<a name="shared-data"></a>
## Shared Data

Just like inertia suggests, we store passed data in the `app/Http/Middleware/HandleInertiaRequests.php`.  By default we 
share the results of our basic menus (admin, left menu, right menu) and common flash messages (success and error).  These 
get passed down and used by our included vue files.

- The flash messages are handled in `resources/js/Shared/Layout` and `resources/js/Shared/Admin`.
- The menus are used in `resources/js/Shared/Menu/Main` (for the left and right menus) and the admin menu is used in 
`resources/js/Shared/Admin/Main`.

If you want to add anything to shared, this would be where and how to do it. 

<a name="forms"></a>
## Forms

When first trying out inertia we used axios for submitting forms from the vue pages.  Inertia has updated since then and 
has some amazing built in form handling.  You can see examples of this in some of our user package pages.  For the basic 
docs (which are very easy to follow), look directly to [their site](https://inertiajs.com/forms).

<a name="packages"></a>
## Packages

We also include some common packages used in Vue/Inertia.  All of these packages are set up in `app.js`.

Package          | What it does                                  | Docs
---------------- | --------------------------------------------- | -------
Portal-Vue       | Allows placing components anywhere.           | [Docs](https://portal-vue.linusb.org/guide/getting-started.html)
Vue-Meta         | Easily allows adding meta tags from Vue.      | [Docs](https://vue-meta.nuxtjs.org/)
Moment-Vue       | Adds moment.js into vue.                      | [GitHub](https://github.com/brockpetrie/vue-moment) | [Moment.js](https://momentjs.com/docs/)
Inertia Progress | Adds a progress bar when the page is loading. | [Docs](https://inertiajs.com/progress-indicators)
Ziggy            | Adds laravel routes to js.                    | [GitHub](https://github.com/tighten/ziggy)

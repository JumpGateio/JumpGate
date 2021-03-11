# Enforcing PSR-12 in your Editor

---

- [PHPStorm](#phpstorm)
- [Sublime Text 3](#sublime-text-3)

<a name="phpstorm"></a>
## PHPStorm

To get notifications about violations to PSR-1 and PSR-12 is a built in feature of PHPStorm, you just have to en.

1. Open PHPStorm
1. Open to `Preferences` (`super` + `,`)
1. Go to `Editor` > `Code Style` > `PHP`.
1. Click `Set from...` in the top right of this window.
1. Mouse over `Predefined Style` and select `PSR1/PSR2`

This will leave any extra settings you have alone, but conform required settings to the PSR standards.

<a name="sublime-text-3"></a>
## Sublime Text 3

To get this working in Sublime is a bit more involved.  You will need to use a package to do this.  The documentation can 
be found [on the sublime-phpcs](https://benmatselby.github.io/sublime-phpcs/) docs.

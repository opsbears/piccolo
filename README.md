# The Piccolo framework

Piccolo is a micro framework with a strong emphasis on replacing components and being hackable.

## Installation

The easiest way to install piccolo is to create a fresh project with the skeleton repository:

```
composer create-project opsbears/piccolo-skel -s dev
```

You can also install the individual packages. Since the whole infrastructure is set up around tiny packages, the core
package (`opsbears/piccolo`) doesn't pull in even the most basic services. In other words, you will need to install a
whole list of individual packages. See below for the list of all official packages.

## Official packages

The list of official packages [can be found on Packagist](https://packagist.org/search/?q=opsbears%2Fpiccolo) by 
searching for `opsbears/piccolo`.

## Usage

Piccolo doesn't enforce any way of building your application. If you want to read about the recommended way of 
setting up your application, read the readme on [opsbears/piccolo-skel](https://github.com/opsbears/piccolo-skel).

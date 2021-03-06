# The Piccolo framework [![Build Status](https://travis-ci.org/opsbears/piccolo.svg?branch=master)](https://travis-ci.org/opsbears/piccolo) [![Code Coverage](https://scrutinizer-ci.com/g/opsbears/piccolo/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/opsbears/piccolo/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/opsbears/piccolo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/opsbears/piccolo/?branch=master)

Piccolo is a micro framework with a strong emphasis on replacing components and being hackable.

## Licence

This package is licenced under the MIT licence, available in the [LICENCE.md](LICENCE.md) file in this repository.

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

The recommended way of building your application is by using modules. Details on writing modules can be found in the
[HACKING.md](HACKING.md) file in this repository.

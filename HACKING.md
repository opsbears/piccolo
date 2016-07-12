# Hacking Piccolo

Piccolo, by default, doesn't come with anything, not even the web parts. You can load those from separate packages. 
In order to write your own packages, you should be aware of a few things:

## Dependency injection

As per clean code, dependencies should be explicit. Piccolo uses a dependency injection container (configurable) to 
detect what parameters classes need and create them.

Piccolo also makes heavy use of interfaces, so configuring the DIC is very important.

## Modules

A module works like bundles in Symfony, the are a way to organize and wire up your dependency injection. Each module 
has four functions:

### `getModuleKey()`
Returns a string. This will be used as a configuration key, and probably other things too.

###`getRequiredModules()`

Returns a list of modules that should be (automatically) loaded before the module in question.

### `loadConfiguration()`
Gives the module a chance to load additional configuration, and wire up other modules.

### `configureDependencyInjection()`

Configure the dependency injection container for the classes of the module.

## Application

An application is the most basic part of the stack. It gets passed the dependency injection container and the 
configuration as an array, and is free to do as it pleases. It is a good practice to try and keep the DIC within the 
application only. For simpler DIC handling extend `AbstractApplication`.

A good example of an application is the `WebApplication` class in the `piccolo-web` package.

## Writing a module

When you are writing a module, it is a good practice to define a module class that either inherit from `AbstractModule`
or implement the `Module` interface. This class allows you to link up your classes to the interfaces they implement. 
For example a module that implements an interface named `Foo` could look like this:

```
class MyModule extends AbstractModule {
    public function configureDependencyInjection(
        DependencyInjectionContainer $dic,
        array $moduleConfig,
        array $globalConfig) {
        
        $dic->alias(Foo::class, MyFooImplementation::class);
    }
}
```

You can, of course, also use `configureDependencyInjection()` function to map configuration options to your classes:

```
class MyModule extends AbstractModule {
    public function configureDependencyInjection(
        DependencyInjectionContainer $dic,
        array $moduleConfig,
        array $globalConfig) {
        
        //...
        
        $dic->setClassParameters(MyFooImplementation::class, ['myParameter' => $moduleConfig['myParameter']]);
    }
}
```
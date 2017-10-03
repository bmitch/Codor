# Code Odor Sniffer
:nose: :poop: Custom PHP Code Sniffer sniffs to help find Code Smells (Odor).

[![Build Status](https://travis-ci.org/bmitch/Codor.svg?branch=master)](https://travis-ci.org/bmitch/Codor) 
[![codecov](https://codecov.io/gh/bmitch/Codor/branch/master/graph/badge.svg)](https://codecov.io/gh/bmitch/Codor) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bmitch/Codor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bmitch/Codor/?branch=master) 
[![Code Climate](https://codeclimate.com/github/bmitch/Codor/badges/gpa.svg)](https://codeclimate.com/github/bmitch/Codor) 
[![Packagist](https://img.shields.io/packagist/v/bmitch/codor.svg)](https://packagist.org/packages/bmitch/codor) 
[![Packagist](https://img.shields.io/packagist/l/bmitch/codor.svg)]()
[![Packagist](https://img.shields.io/packagist/dt/bmitch/codor.svg)](https://packagist.org/packages/bmitch/codor)
----------
_Inspired by: https://github.com/object-calisthenics/phpcs-calisthenics-rules_

* [What Is it?](#what-is-it)
* [Compatibility](#compatibility)
* [How to Install?](#how-to-install)
* [How to Use?](#how-to-use)
 * [Omitting Sniffs](#omitting-sniffs)
 * [Running Specific Sniffs](#running-specific-sniffs)
* [Sniffs Included](#sniffs-included)
* [Customizing Sniffs](#customizing-sniffs)
 * [Customizations Available](#customizations-available)
* [Similar Packages](#similar-packages)
* [Contributing](#contributing)
* [License](#license)

## What is it? ##
This package is a set of custom Sniffs for the [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer) that you can use in your CI build to ensure the ingegrity of your code base.

## Compatibility ##
* PHP 7+ please use v1.0.0 and above.
* PHP 5.6 and below please use any version below v1.0.0.

## How to Install? ##
Install via Composer:
```
composer require bmitch/codor --dev
```

## How to Use? ##
Create a PHPCS ruleset XML (`codor.xml` or whatever filename you want) file in the root of your project.
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="Project">
    <description>Project Coding Standard</description>

    <rule ref="vendor/bmitch/codor/src/Codor/ruleset.xml"/>
</ruleset>
```

Then run it with the command:
```
vendor/bin/phpcs --standard=codor.xml src 
```

Where `src` is the location of the source code you want to check.

### Omitting Sniffs ###
You may not want to run all the sniffs provided so you can specify which sniffs you want to exclude with the `--exclude` flag like:
```
vendor/bin/phpcs --standard=codor.xml --exclude=Codor.ControlStructures.NoElse src
```
(if you want to exclude multiple just separate them with a comma)

### Running Specific Sniffs ###
Or you can also specify which sniffs to specifically run:
```
vendor/bin/phpcs --standard=codor.xml --sniffs=Codor.ControlStructures.NoElse src
```

### Suppressing the sniffs on specific pieces of code
Please see the PHPCS documentation:  
https://github.com/squizlabs/PHP_CodeSniffer/wiki/Advanced-Usage#ignoring-files-and-folders

## Sniffs Included ##
### Codor.ControlStructures.NoElse ###
Does not allow for any `else` or `elseif` statements.

:x:
```php
if ($foo) {
    return 'bar';
} else {
    return 'baz';
}
```

:white_check_mark:
```php
if ($foo) {
    return 'bar';
}
return 'baz';
```

### Codor.Files.FunctionLength ###
Functions/methods must be no more than 20 lines.

:x:
```php
public function foo()
{
    // more than 20 lines
}
```

:white_check_mark:
```php
public function foo()
{
    // no more than 20 lines
}
```
### Codor.Files.FunctionParameter ###
Functions/methods must have no more than 3 parameters.

:x:
```php
public function foo($bar, $baz, $bop, $portugal)
{
    // 
}
```

:white_check_mark:
```php
public function foo($bar, $baz, $bop)
{
    // 
}
```
### Codor.Files.ReturnNull ###
Functions/methods must not return `null`.

:x:
```php
public function getAdapter($bar)
{
    if ($bar === 'baz') {
        return new BazAdapter;
    }
    return null;
}
```

:white_check_mark:
```php
public function getAdapter($bar)
{
    if ($bar === 'baz') {
        return new BazAdapter;
    }
    return NullAdapter;
}
```
### Codor.Files.MethodFlagParameter ###
Functions/methods cannot have parameters that default to a boolean.

:x:
```php
public function getCustomers($active = true)
{
    if ($active) {
        // Code to get customers from who are active
    }
    
    // Code to get all customers
}
```

:white_check_mark:
```php
public function getAllCustomers()
{    
    // Code to get all customers
}

public function getAllActiveCustomers()
{    
    // Code to get customers from who are active
}
```
### Codor.Classes.ClassLength ###
Classes must be no more than 200 lines.

:x:
```php
class ClassTooLong
{
    // More than 200 lines
}
```

:white_check_mark:
```php
class ClassNotTooLong
{
    // No more than 200 lines
}
```
### Codor.Classes.ConstructorLoop ###
Class constructors must not contain any loops.

:x:
```php
public function __construct()
{
    for($index = 1; $index < 100; $index++) {
        // foo
    }
}
```

:white_check_mark:
```php
public function __construct()
{
    $this->someMethod();
}

private function someMethod()
{
    for($index = 1; $index < 100; $index++) {
        // foo
    }
}

```
### Codor.Classes.Extends ###
Warns if a class extends another class. Goal is to promote composition over inheritance (https://en.wikipedia.org/wiki/Composition_over_inheritance).

:x:
```php
class GasolineCar extends Vehicle
{
    //
}

class GasolineVehicle extends Vehicle
{
    //
}
```

:white_check_mark:
```php
class Vehicle
{
    private $fuel;
    
    public function __construct(FuelInterface $fuel)
    {
        $this->fuel;    
    }
}

class Gasoline implements FuelInterface
{

}

$gasolineCar = new Vehicle($gasoline);
```
### Codor.Classes.FinalPrivate ###
Final classes should not contain protected methods or variables. Should use private instead.

:x:
```php
final class Foo 
{
    protected $baz;

    protected function bar()
    {
        //
    }
}
```

:white_check_mark:
```php
final class Foo 
{
    private $baz;

    private function bar()
    {
        //
    }
}
```
### Codor.Classes.PropertyDeclaration ###
Produces an error if your class uses undeclared member variables. Only warns if class extends another class. 

:x:
```php
class Foo 
{
    private function bar()
    {
        $this->baz = 13;
    }
}
```

:white_check_mark:
```php
class Foo 
{
    private $baz;
    
    private function bar()
    {
        $this->baz = 13;
    }
}
```
### Codor.Files.FunctionNameContainsAndOr ###
Functions/methods cannot contain "And" or "Or". This could be a sign of a function that does more than one thing.

:x:
```php
public function validateStringAndUpdateDatabase()
{
    // code to validate string
    // code to update database
}
```

:white_check_mark:
```php
public function validateString()
{
    // code to validate string
}

public function updateDatabase()
{
    // code to update database
}
```
### Codor.Files.IndentationLevel ###
Functions/methods cannot have more than 2 level of indentation.

:x:
```php
public function foo($collection)
{
    foreach ($collection as $bar) {
        foreach ($bar as $baz) {
            //
        }
    }
}
```

:white_check_mark:
```php
public function foo($collection)
{
    foreach ($collection as $bar) {
        $this->process($bar);
    }
}

private function process($bar)
{
    foreach ($bar as $baz) {
        //
    }
}
```
### Codor.ControlStructures.NestedIf ###
Nested if statements are not allowed.

:x:
```php
public function allowedToDrink($person)
{
    if ($person->age === 19) {
        if ($person->hasValidId()) {
            return true;
        }
    }
    
    return false;
}
```

:white_check_mark:
```php
public function allowedToDrink($person)
{
    if ($person->age !== 19) {
        return false;
    }
       
    if (! $person->hasValidId()) {
        return false;
    }
    
    return true;
}
```
### Codor.Syntax.NullCoalescing ###
Produces an error if a line contains a ternary operator that could be converted to a Null Coalescing operator.

:x:
```php
$username = isset($customer['name']) ? $customer['name'] : 'nobody';
```

:white_check_mark:
```php
$username = $customer['name'] ?? 'nobody';
```

### Codor.Syntax.LinesAfterMethod ###
Only allows for 1 line between functions/methods. Any more than 1 will produce an error.

:x:
```php
public function foo()
{
    //
}


public function bar()
{
    //
}
```

:white_check_mark:
```php
public function foo()
{
    //
}

public function bar()
{
    //
}
```

## Customizing Sniffs ##
Some of the sniff rules can be customized to your liking. For example, if you'd want the `Codor.Files.FunctionLength` to make sure your functions are no more than 30 lines instead of 20, you can do that. Here's an example of a `codor.xml` file with that customization:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="Project">
    <description>Project Coding Standard</description>

    <rule ref="vendor/bmitch/codor/src/Codor/ruleset.xml"/>
	<rule ref="Codor.Files.FunctionLength">
		<properties>
			<property name="maxLength" value="30"/>
		</properties>
	</rule>
</ruleset>
```

### Customizations Available
* `Codor.Files.FunctionLength`
 * `maxLength`: The maximum number of lines a function/method can have (default = 20).
* `Codor.Files.FunctionParameter`
 * `maxParameters`: The maximum number of parameters a function/method can have (default = 3).
* `Codor.Classes.ClassLength`
 * `maxLength`: The maximum number of lines a Class can have (default = 200).
* `Codor.Files.IndentationLevel`
 * `indentationLimit`: Cannot have more than or equal to this number of indentations (default = 2).

## Similar Packages
* https://github.com/object-calisthenics/phpcs-calisthenics-rules
* https://github.com/slevomat/coding-standard

## Contributing ##
Please see [CONTRIBUTING.md](CONTRIBUTING.md)

## License ##

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

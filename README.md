# Code Odor Sniffer
Custom PHP Code Sniffer sniffs to help find Code Smells (Odor).

[![Build Status](https://travis-ci.org/bmitch/Codor.svg?branch=master)](https://travis-ci.org/bmitch/Codor) [![codecov](https://codecov.io/gh/bmitch/Codor/branch/master/graph/badge.svg)](https://codecov.io/gh/bmitch/Codor) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bmitch/Codor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bmitch/Codor/?branch=master) [![Code Climate](https://codeclimate.com/github/bmitch/Codor/badges/gpa.svg)](https://codeclimate.com/github/bmitch/Codor) [![Packagist](https://img.shields.io/packagist/v/bmitch/codor.svg)]() [![Packagist](https://img.shields.io/packagist/l/bmitch/codor.svg)]()
----------
_Inspired by: https://github.com/object-calisthenics/phpcs-calisthenics-rules_

* [What Is it?](#what-is-it)
* [How to Install?](#how-to-install)
* [How to Use?](#how-to-use)
 * [Omitting Sniffs](#omitting-sniffs)
 * [Running Specific Sniffs](#running-specific-sniffs)
* [Sniffs Included](#sniffs-included)
* [Customizing Sniffs](#customizing-sniffs)
 * [Customizations Available](#customizations-available)
* [Contributing](#contributing)
* [License](#license)

## What is it? ##
This package is a set of custom Sniffs for the [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer) that you can use in your CI build to ensure the ingegrity of your code base.

## How to Install? ##

Install via Composer:
```
composer require bmitch/codor --dev
```

## How to Use? ##
Create a PHPCS ruleset XML (`codor.xml` or whatever filename you want) file in the root of your project.
```
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

## Sniffs Included ##
### Codor.ControlStructures.NoElse ###
Does not allow for any `else` or `elseif` statements.

### Codor.Files.FunctionLength ###
Functions/methods must be no more than 20 lines.

### Codor.Files.FunctionParameter ###
Functions/methods must have no more than 3 parameters.

### Codor.Files.ReturnNull ###
Functions/methods must not return `null`.

### Codor.Classes.ClassLength ###
Classes must be no more than 200 lines.

### Codor.Files.FunctionNameContainsAndOr ###
Functions/methods cannot contain "And" or "Or". This could be a sign of a function that does more than one thing.

## Customizing Sniffs ##
Some of the sniff rules can be customized to your liking. For example, if you'd want the `Codor.Files.FunctionLength` to make sure your functions are no more than 30 lines instead of 20, you can do that. Here's an example of a `codor.xml` file with that customization:
```
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
 * `maxLength`: The maximum number of lines a function/method can be.
* `Codor.Files.FunctionParameter`
 * `maxParameters`: The maximum number of parameters a function/method can have.
* `Codor.Classes.ClassLength`
 * `maxLength`: The maximum number of lines a Class can be.

## Contributing ##
Please see [CONTRIBUTING.md](CONTRIBUTING.md)

## License ##

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

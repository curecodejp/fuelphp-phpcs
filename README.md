# PHP_CodeSniffer FuelPHP Standard

English | [日本語](README.ja.md)

PHP_CodeSniffer rules that cover a large part of the [FuelPHP coding standards](http://docs.fuelphp.com/general/coding_standards.html).

> This README is the source of truth. When you change it, update [README.ja.md](README.ja.md) in the same pull request.

## About this fork

This is a fork of [eviweb/fuelphp-phpcs](https://github.com/eviweb/fuelphp-phpcs). The upstream has not been updated since 2020 and supports PHP_CodeSniffer 2.x only. This fork ports all custom sniffs to PHP_CodeSniffer 3.x (v2.0.0).

- The package name is still `eviweb/fuelphp-phpcs`.
- The package of the same name on Packagist is the upstream v1.x. This fork (v2.x) is not on Packagist; add this repository to `repositories` in your `composer.json` (see below).

## Requirements

- PHP >= 8.0
- PHP_CodeSniffer 3.x (3.1 or later)

## Installation

### 1. Add to composer.json

Add this repository to `repositories` and the dependencies to `require-dev` in your `composer.json`.

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/curecodejp/fuelphp-phpcs.git",
            "only": ["eviweb/fuelphp-phpcs"]
        }
    ],
    "require-dev": {
        "squizlabs/php_codesniffer": "^3.0",
        "eviweb/fuelphp-phpcs": "^2.0",
        "dealerdirect/phpcodesniffer-composer-installer": "^1.0"
    },
    "config": {
        "allow-plugins": {
            "dealerdirect/phpcodesniffer-composer-installer": true
        }
    }
}
```

### 2. Install

```bash
composer update squizlabs/php_codesniffer eviweb/fuelphp-phpcs dealerdirect/phpcodesniffer-composer-installer
```

If your project has no `composer.lock` yet, run `composer update` without package names instead.

`dealerdirect/phpcodesniffer-composer-installer` registers the FuelPHP standard with phpcs automatically.

### 3. Verify the installation

The examples below use `./vendor/bin/phpcs`. A typical FuelPHP project sets `vendor-dir` to `fuel/vendor`, so use `./fuel/vendor/bin/phpcs` there (check with `composer config bin-dir`).

```bash
# Check the phpcs version
./vendor/bin/phpcs --version
# PHP_CodeSniffer version 3.x.x ...

# Check that the FuelPHP standard is registered
./vendor/bin/phpcs -i
# The installed coding standards are ... FuelPHP ...

# List the available sniffs
./vendor/bin/phpcs --standard=FuelPHP -e
```

## Usage

### Basic usage

```bash
# Check a whole directory
./vendor/bin/phpcs --standard=FuelPHP fuel/app/classes/

# Check a single file
./vendor/bin/phpcs --standard=FuelPHP fuel/app/classes/util.php
```

### Project-specific settings (phpcs.xml)

Create `phpcs.xml` in your project root to exclude rules or set paths for your project.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="MyProject">
    <description>MyProject coding standard based on FuelPHP</description>

    <!-- Use the FuelPHP standard as the base -->
    <rule ref="FuelPHP">
        <!-- Example: exclude rules you do not need -->
        <exclude name="FuelPHP.NamingConventions.ConciseUnderscoredVariableName.NotUnderscore"/>
        <exclude name="FuelPHP.NamingConventions.LowerCaseFileName.UpperCaseInFileName"/>
    </rule>

    <!-- Directories to check -->
    <file>fuel/app/classes</file>
    <file>fuel/app/views</file>
    <file>fuel/app/tasks</file>

    <!-- Directories to skip -->
    <exclude-pattern>fuel/app/vendor/*</exclude-pattern>
    <exclude-pattern>fuel/core/*</exclude-pattern>
    <exclude-pattern>fuel/packages/*</exclude-pattern>
</ruleset>
```

With `phpcs.xml`:

```bash
# phpcs.xml is detected automatically when run from the project root
./vendor/bin/phpcs

# Or specify it explicitly
./vendor/bin/phpcs --standard=phpcs.xml fuel/app/classes/
```

### VS Code integration

1. Install the VS Code extension `shevaua.phpcs`.
2. Add the following to `.vscode/settings.json`:

```json
{
    "phpcs.executablePath": "fuel/vendor/bin/phpcs",
    "phpcs.standard": "phpcs.xml"
}
```

> **Note**: The path `fuel/vendor/bin/phpcs` depends on the `vendor-dir` setting in your project's composer configuration. It is `fuel/vendor/bin/phpcs` in a typical FuelPHP project.

### Automatic fixes (phpcbf)

Some errors can be fixed automatically with `phpcbf`:

```bash
./vendor/bin/phpcbf --standard=FuelPHP fuel/app/classes/
```

## Included sniffs

### Custom sniffs (FuelPHP-specific)

| Sniff | Description |
|---|---|
| `FuelPHP.Arrays.ArrayDeclaration` | Array declaration format (alignment, line breaks, etc.) |
| `FuelPHP.Classes.ClassDeclaration` | Class / interface declaration format |
| `FuelPHP.Formatting.BracesOnNewLine` | Braces of control structures on the next line (Allman style) |
| `FuelPHP.NamingConventions.ConciseUnderscoredVariableName` | Variable names in underscore style, 30 characters or fewer |
| `FuelPHP.NamingConventions.LowerCaseFileName` | File names all lowercase |
| `FuelPHP.NamingConventions.UnderscoredWithScopeFunctionName` | Method names in underscore style with explicit visibility |
| `FuelPHP.WhiteSpace.ControlStructureSpacing` | Spacing around parentheses of control structures |
| `FuelPHP.WhiteSpace.DisallowSpaceIndent` | Indent with tabs only (no spaces) |
| `FuelPHP.WhiteSpace.IncrementDecrementSpacing` | No space between `++` / `--` and the variable |
| `FuelPHP.WhiteSpace.NotOperatorSpacing` | Spaces required around the `!` operator |

### External sniffs (standard phpcs rules)

19 sniffs from Generic, PEAR, Squiz and Zend are used.
See `Standards/FuelPHP/ruleset.xml` for details.

## Migrating from phpcs 2.x

To migrate from phpcs 2.x (v1.x):

1. Add this repository to `repositories` and allow the plugin in `config.allow-plugins`, as in [1. Add to composer.json](#1-add-to-composerjson).
2. Change `squizlabs/php_codesniffer` in `composer.json` to `"^3.0"`.
3. Change `eviweb/fuelphp-phpcs` to `"^2.0"`.
4. Add `dealerdirect/phpcodesniffer-composer-installer` (`"^1.0"`).
5. If `phpcs.xml` uses shortened sniff names, change them to the full names.
   - Example: `UnderscoredWithScope` → `UnderscoredWithScopeFunctionName`
6. Run `composer update`.

## License

MIT License

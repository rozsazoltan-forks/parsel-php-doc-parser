# Upgrading to Parsel 1.0

Parsel 1.0 introduces parser drivers. LiteParse remains the default, so basic `file()`, `bytes()`, `markdown()`, `text()`, `parse()`, `toArray()`, `save()`, `screenshots()`, and `lazyPages()` calls continue to work.

## Move LiteParse settings into provider options

Parser-specific fluent methods were removed from `PendingParse`. Create one `LiteParseOptions` object and pass it to `withProviderOptions()`.

```php
// Parsel 0.x
Parsel::file('scan.pdf')
    ->pageRange(1, 5)
    ->withOcr(language: 'eng')
    ->withDpi(300)
    ->parse();

// Parsel 1.0
use Shipfastlabs\Parsel\Options\LiteParseOptions;

Parsel::file('scan.pdf')
    ->withProviderOptions(
        LiteParseOptions::make()
            ->pageRange(1, 5)
            ->withOcr(language: 'eng')
            ->withDpi(300)
    )
    ->parse();
```

The following methods moved to `LiteParseOptions`: `page`, `pages`, `pageRange`, `maxPages`, `ocr`, `withOcr`, `withoutOcr`, `withDpi`, `preserveSmallText`, `withPassword`, `withImages`, `withoutImages`, `links`, `withoutLinks`, `keepHeadersAndFooters`, `withBinary`, and `option`.

The old `dpi`, `password`, and `binary` aliases were removed. Use `withDpi`, `withPassword`, and `withBinary` on the options object.

Strict arrays are also supported:

```php
Parsel::file('scan.pdf')->withProviderOptions([
    'pages' => '1-5',
    'ocr' => true,
    'ocr_language' => 'eng',
    'dpi' => 300,
]);
```

Unknown keys now throw `InvalidProviderOptionsException`. Use the typed options object's `option()` method for an upstream flag that Parsel does not know yet.

## Select a driver

LiteParse remains implicit. AnyDoc and custom drivers are selected before the source:

```php
Parsel::driver('anydoc')->file('report.docx')->markdown();

Parsel::defaultDriver('anydoc');
Parsel::file('report.docx')->markdown();
```

AnyDoc only provides Markdown through its current CLI. Calling `text`, `parse`, `toArray`, `lazyPages`, or `screenshots` with AnyDoc throws `UnsupportedCapabilityException`.

## Binary configuration

`Parsel::usingBinary()` and request-level `withBinary()` were removed because the binary belongs to a driver.

```php
Parsel::file('report.pdf')->withProviderOptions(
    LiteParseOptions::make()->withBinary('/usr/local/bin/lit')
);

Parsel::driver('anydoc')->file('report.docx')->withProviderOptions(
    AnyDocOptions::make()->withBinary('/usr/local/bin/anydoc')
);
```

Replace `PARSEL_LIT_BINARY` with `PARSEL_LITEPARSE_BINARY`. The old variable remains a fallback for 1.0. AnyDoc uses `PARSEL_ANYDOC_BINARY`.

## Installer

`vendor/bin/parsel-install` replaces the LiteParse-specific installer and accepts `--driver=liteparse|anydoc|all`. The old `vendor/bin/parsel-install-lit` command remains as an alias.

## Extending Parsel

Replace process-runner substitution used as an application-level parser integration with a registered driver:

```php
Parsel::extend('company-api', fn (ParselManager $manager): Driver => new CompanyApiDriver);
```

Implement `Driver` for Markdown and only the optional capability contracts supported by the provider. `Parsel::swap()` remains available for testing the two bundled CLI drivers.

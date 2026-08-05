# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

## [1.0.0]

### Added

- Laravel-style driver manager with LiteParse and AnyDoc CLI drivers.
- Public driver and optional capability contracts for third-party providers.
- Typed `LiteParseOptions` and `AnyDocOptions` with strict array support.
- Generic `parsel-install` command and AnyDoc installation support.
- `UPGRADE.md` migration guide.

### Changed

- LiteParse remains the default driver.
- Provider-only request methods moved to `withProviderOptions()`.
- Binary resolution is provider-specific.

### Removed

- Ambiguous global and request-level LiteParse option shortcuts. See `UPGRADE.md`.

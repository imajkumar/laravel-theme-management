# Changelog

All notable changes to the Laravel Themes package will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Laravel 12.x compatibility
- PHP 8.2+ support
- Modern dependency management
- Enhanced documentation
- Contributing guidelines
- Comprehensive testing setup

### Changed
- Updated PHP requirement from 7.2+ to 8.2+
- Updated Laravel support from 9-10 to 12.x
- Improved composer.json structure
- Enhanced README.md with modern formatting
- Updated phpunit.xml for modern PHPUnit

### Removed
- Deprecated SerializableClosure usage
- Legacy PHP 7.x compatibility
- Outdated Laravel version support

## [2.0.0] - 2024-12-19

### Added
- Full Laravel 12.x compatibility
- PHP 8.2+ requirement
- Improved performance and security
- Modern dependency management
- Enhanced documentation
- Professional README with badges
- Contributing guidelines
- CHANGELOG tracking

### Changed
- Updated package description and keywords
- Improved composer.json structure
- Enhanced configuration file
- Modernized testing setup
- Better code organization

### Fixed
- Laravel 12 compatibility issues
- Deprecated method usage
- Configuration file structure
- Testing configuration

## [1.0.0] - 2023-01-01

### Added
- Basic theme management system
- Asset management
- Widget system
- Breadcrumb functionality
- Blade directives
- Artisan commands
- Middleware support
- Laravel 9-10 compatibility
- PHP 7.2+ support

### Features
- Theme creation and management
- Layout system
- Partial views
- Asset pipeline
- Widget generation
- Theme duplication
- Theme destruction
- Theme listing

---

## Version Compatibility

| Version | Laravel | PHP | Status |
|---------|---------|-----|--------|
| 2.0.0   | 12.x    | 8.2+ | ✅ Active |
| 1.0.0   | 9-10    | 7.2+ | ❌ Deprecated |

## Migration Guide

### From Version 1.x to 2.x

1. **Update PHP Version**: Ensure you're running PHP 8.2 or higher
2. **Update Laravel**: Upgrade to Laravel 12.x
3. **Update Dependencies**: Run `composer update ayra/laravel-themes`
4. **Check Configuration**: Review your theme configuration files
5. **Test Functionality**: Ensure all features work as expected

### Breaking Changes

- PHP 8.2+ required (was 7.2+)
- Laravel 12.x required (was 9-10)
- Configuration file structure updated
- Some deprecated methods removed

---

For detailed information about each release, please refer to the [GitHub releases page](https://github.com/ayra/laravel-themes/releases).

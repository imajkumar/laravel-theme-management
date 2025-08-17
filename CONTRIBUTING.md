# Contributing to Laravel Themes

Thank you for your interest in contributing to Laravel Themes! This document provides guidelines and information for contributors.

## 🤝 How to Contribute

### Reporting Issues

- Use the [GitHub issue tracker](https://github.com/ayra/laravel-themes/issues)
- Search existing issues before creating a new one
- Provide a clear and descriptive title
- Include steps to reproduce the issue
- Share your Laravel and PHP versions
- Include any relevant error messages or logs

### Suggesting Features

- Use the [GitHub Discussions](https://github.com/ayra/laravel-themes/discussions) for feature requests
- Clearly describe the feature and its benefits
- Provide use cases and examples
- Consider if the feature aligns with the package's scope

### Code Contributions

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/amazing-feature`
3. **Make your changes**
4. **Write or update tests**
5. **Ensure code quality**:
   - Follow PSR-12 coding standards
   - Add proper PHPDoc comments
   - Write meaningful commit messages
6. **Test your changes**: `composer test`
7. **Commit your changes**: `git commit -m 'Add amazing feature'`
8. **Push to your branch**: `git push origin feature/amazing-feature`
9. **Create a Pull Request**

## 🛠️ Development Setup

### Prerequisites

- PHP 8.2 or higher
- Composer
- Git

### Local Development

1. **Clone your fork:**
   ```bash
   git clone https://github.com/YOUR_USERNAME/laravel-themes.git
   cd laravel-themes
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Run tests:**
   ```bash
   composer test
   ```

4. **Run tests with coverage:**
   ```bash
   composer test -- --coverage
   ```

### Testing

- Write tests for new features
- Ensure all existing tests pass
- Aim for high test coverage
- Test with different Laravel versions if applicable

## 📝 Code Standards

### PHP Standards

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Use type hints and return types (PHP 8.0+)
- Add proper PHPDoc comments for public methods
- Use meaningful variable and method names

### Laravel Standards

- Follow Laravel conventions and best practices
- Use Laravel's built-in features when possible
- Maintain backward compatibility when possible
- Follow Laravel's naming conventions

### Git Standards

- Use conventional commit messages
- Keep commits focused and atomic
- Reference issues in commit messages when applicable
- Use descriptive branch names

## 🧪 Testing Guidelines

### Test Structure

- Place tests in the `tests/` directory
- Use descriptive test method names
- Group related tests in test classes
- Mock external dependencies when appropriate

### Test Examples

```php
<?php

namespace Ayra\Theme\Tests;

use Ayra\Theme\Theme;
use Orchestra\Testbench\TestCase;

class ThemeTest extends TestCase
{
    public function test_theme_can_be_created()
    {
        $theme = new Theme();
        $this->assertInstanceOf(Theme::class, $theme);
    }
}
```

## 📚 Documentation

### Code Documentation

- Document all public methods and classes
- Include usage examples in PHPDoc
- Keep documentation up-to-date with code changes

### README Updates

- Update README.md for new features
- Include usage examples
- Update version compatibility information
- Keep installation instructions current

## 🚀 Release Process

### Version Bumping

- Follow [Semantic Versioning](https://semver.org/)
- Update version in `composer.json`
- Update CHANGELOG.md with new features and fixes
- Tag releases with version numbers

### Pre-release Checklist

- [ ] All tests pass
- [ ] Documentation is updated
- [ ] CHANGELOG.md is updated
- [ ] Version numbers are updated
- [ ] Dependencies are up-to-date

## 🐛 Bug Fixes

### Before Fixing

- Reproduce the issue locally
- Identify the root cause
- Check if it's a regression
- Consider backward compatibility

### Fix Guidelines

- Fix the root cause, not just symptoms
- Add tests to prevent regression
- Document the fix in CHANGELOG.md
- Consider if the fix affects other areas

## ✨ Feature Development

### Feature Guidelines

- Align with package goals and scope
- Consider backward compatibility
- Include comprehensive tests
- Update documentation
- Consider performance implications

### Feature Checklist

- [ ] Feature is well-defined and scoped
- [ ] Tests cover all scenarios
- [ ] Documentation is updated
- [ ] Examples are provided
- [ ] Performance impact is considered

## 📞 Getting Help

### Questions and Support

- Use [GitHub Discussions](https://github.com/ayra/laravel-themes/discussions) for questions
- Check existing documentation and issues
- Be respectful and patient with maintainers

### Communication

- Be clear and concise
- Provide context for your questions
- Use appropriate channels for different types of communication
- Respect the time of maintainers and contributors

## 🎯 Contribution Areas

We welcome contributions in these areas:

- **Bug fixes** - Fix existing issues
- **New features** - Add useful functionality
- **Documentation** - Improve guides and examples
- **Tests** - Increase test coverage
- **Performance** - Optimize existing code
- **Security** - Identify and fix security issues

## 🙏 Recognition

- Contributors will be credited in the CHANGELOG.md
- Significant contributions may be recognized in the README
- All contributors are appreciated and valued

## 📄 License

By contributing to Laravel Themes, you agree that your contributions will be licensed under the MIT License.

---

Thank you for contributing to Laravel Themes! Your efforts help make this package better for the entire Laravel community.

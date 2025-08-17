# Security Policy

## Supported Versions

We actively maintain and provide security updates for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 2.x.x   | :white_check_mark: |
| 1.x.x   | :x:                |

## Reporting a Vulnerability

We take security vulnerabilities seriously. If you discover a security vulnerability within Laravel Themes, please follow these steps:

### 1. **DO NOT** create a public GitHub issue
Public issues can lead to security vulnerabilities being exploited before they're patched.

### 2. **DO** report the vulnerability privately
Send an email to **ajayit2020@gmail.com** with the following information:

- **Subject**: `[SECURITY] Laravel Themes Vulnerability Report`
- **Description**: Detailed description of the vulnerability
- **Steps to reproduce**: Clear steps to reproduce the issue
- **Impact**: Potential impact of the vulnerability
- **Affected versions**: Which versions are affected
- **Suggested fix**: If you have a solution in mind

### 3. **DO** include technical details
- PHP version
- Laravel version
- Package version
- Any relevant error messages or logs
- Code examples if applicable

### 4. **DO** be patient
We will acknowledge your report within 48 hours and provide updates on our progress.

## What Happens Next

1. **Acknowledgment**: You'll receive an acknowledgment within 48 hours
2. **Investigation**: Our team will investigate the reported vulnerability
3. **Fix Development**: We'll develop and test a fix
4. **Release**: We'll release a patched version
5. **Disclosure**: We'll publicly disclose the vulnerability (with credit to you)

## Security Best Practices

### For Users

- Always keep your packages updated to the latest versions
- Regularly check for security advisories
- Use Composer's security audit: `composer audit`
- Monitor the GitHub security tab for this repository

### For Developers

- Follow secure coding practices
- Validate and sanitize all user inputs
- Use HTTPS for all external communications
- Implement proper authentication and authorization
- Keep dependencies updated

## Security Features

Laravel Themes includes several security features:

- **Input Validation**: All user inputs are validated
- **XSS Protection**: Built-in protection against XSS attacks
- **CSRF Protection**: Works with Laravel's CSRF protection
- **Secure Asset Loading**: Secure asset loading mechanisms
- **File Path Validation**: Prevents directory traversal attacks

## Responsible Disclosure

We believe in responsible disclosure:

- **Timeline**: We aim to fix critical vulnerabilities within 30 days
- **Communication**: We'll keep you updated on our progress
- **Credit**: Security researchers will be credited in our security advisories
- **Coordination**: We'll coordinate with you on disclosure timing

## Security Contacts

- **Primary**: ajayit2020@gmail.com
- **Backup**: Create a private GitHub security advisory
- **Response Time**: Within 48 hours for acknowledgment

## Security Hall of Fame

We'd like to thank the following security researchers for their responsible disclosure:

- *No security vulnerabilities reported yet - be the first!*

---

**Thank you for helping keep Laravel Themes secure!**

Your security reports help us maintain a safe and reliable package for the entire Laravel community.

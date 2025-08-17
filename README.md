# Laravel Themes - Theme Management System for Laravel 12.x

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ayra/laravel-themes.svg)](https://packagist.org/packages/ayra/laravel-themes)
[![Total Downloads](https://img.shields.io/packagist/dt/ayra/laravel-themes.svg)](https://packagist.org/packages/ayra/laravel-themes)
[![License](https://img.shields.io/packagist/l/ayra/laravel-themes.svg)](https://packagist.org/packages/ayra/laravel-themes)
[![PHP Version](https://img.shields.io/packagist/php-v/ayra/laravel-themes.svg)](https://packagist.org/packages/ayra/laravel-themes)
[![Laravel Version](https://img.shields.io/packagist/dependency-v/ayra/laravel-themes/laravel/framework.svg)](https://packagist.org/packages/ayra/laravel-themes)

A powerful and modern theme management system for Laravel 12.x that helps you organize themes, layouts, assets, and widgets efficiently. This package is based on [teepluss/theme](https://github.com/teepluss/laravel-theme/) but completely rewritten for modern Laravel compatibility.

## ✨ Features

- 🎨 **Multi-Theme Support**: Create and manage multiple themes with ease
- 🏗️ **Flexible Layouts**: Support for multiple layouts per theme
- 📦 **Asset Management**: Built-in asset pipeline with dependency management
- 🧩 **Widget System**: Create reusable widgets for your themes
- 🍞 **Breadcrumb Management**: Easy breadcrumb generation and customization
- 🔧 **Artisan Commands**: Powerful CLI tools for theme management
- 🎯 **Blade Directives**: Custom Blade directives for theme functionality
- 🚀 **Laravel 12 Ready**: Full compatibility with the latest Laravel version
- 📱 **Middleware Support**: Route-based theme switching
- 🎭 **Partial Views**: Modular view system with partials and sections
- 🔄 **Theme Switching**: Session/cookie-based theme persistence
- 📤 **Export/Import**: Backup and share themes easily
- 💾 **Auto-Backup**: Automatic theme backup with rotation
- 🌐 **CDN Support**: Built-in CDN integration for assets
- 📊 **Theme Statistics**: Get detailed theme information
- 👀 **Theme Preview**: Preview themes via URL parameters
- 🎛️ **Conditional Assets**: Load assets based on conditions
- 🔒 **Asset Integrity**: SRI support for security

## 🚀 Quick Start

### Requirements

- PHP 8.2 or higher
- Laravel 12.x

### Installation

1. **Install via Composer:**

```bash
composer require ayra/laravel-themes
```

2. **Publish Configuration:**

```bash
php artisan vendor:publish --provider="Ayra\Theme\ThemeServiceProvider"
```

3. **Add to .env:**

```env
APP_THEME=default
APP_THEME_LAYOUT=layout
APP_THEME_DIR=public/themes
```

4. **Create Your First Theme:**

```bash
php artisan theme:create default
```

## 📚 Documentation

### Table of Contents

- [Basic Usage](#basic-usage)
- [Theme Management](#theme-management)
- [Asset Management](#asset-management)
- [Layouts & Views](#layouts--views)
- [Widgets](#widgets)
- [Breadcrumbs](#breadcrumbs)
- [Blade Directives](#blade-directives)
- [Configuration](#configuration)
- [Artisan Commands](#artisan-commands)
- [Advanced Features](#advanced-features)
- [Theme Switching](#theme-switching)
- [Export & Import](#export--import)
- [Asset Optimization](#asset-optimization)
- [Theme Preview](#theme-preview)

## 🎯 Basic Usage

### Setting Up a Theme

```php
use Ayra\Theme\Facades\Theme;

// Set theme and layout
Theme::uses('default')->layout('main');

// Render a view
return Theme::view('home.index', ['title' => 'Welcome']);
```

### Controller Integration

```php
namespace App\Http\Controllers;

use Ayra\Theme\Facades\Theme;

class HomeController extends Controller
{
    public function index()
    {
        Theme::uses('default')->layout('main');
        
        return Theme::view('home.index', [
            'title' => 'Welcome to Our Site',
            'description' => 'A beautiful theme-powered website'
        ]);
    }
}
```

## 🎨 Theme Management

### Creating Themes

```bash
# Create a new theme
php artisan theme:create my-theme

# Create theme with custom facade
php artisan theme:create my-theme --facade="MyTheme"

# Duplicate existing theme
php artisan theme:duplicate default new-theme

# List all themes
php artisan theme:list

# Remove a theme
php artisan theme:destroy my-theme
```

### Theme Structure

```
public/themes/my-theme/
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── layouts/
├── partials/
│   └── sections/
├── views/
├── widgets/
├── theme.json
└── config.php
```

### Theme Manifest (theme.json)

```json
{
    "slug": "my-theme",
    "name": "My Beautiful Theme",
    "author": "Your Name",
    "email": "your@email.com",
    "description": "A stunning theme for Laravel applications",
    "web": "https://yoursite.com",
    "license": "MIT",
    "version": "1.0.0"
}
```

## 🔄 Theme Switching

### Session/Cookie Based Switching

```php
// Switch theme and persist in session/cookie
Theme::switch('dark-theme', true);

// Switch theme for current request only
Theme::switch('light-theme', false);

// Get current theme from session/cookie
$currentTheme = Theme::getCurrentTheme();

// Check if specific theme is active
if (Theme::isActive('dark-theme')) {
    // Dark theme specific logic
}

// Clear theme session/cookie
Theme::clearTheme();
```

### Theme Preview via URL

```php
// Preview theme: /home?theme=dark-theme
// Preview layout: /home?layout=mobile

// Add middleware to routes
Route::get('/home', function () {
    return Theme::view('home.index');
})->middleware('theme.preview');
```

### Route-Based Theme Switching

```php
// Apply theme middleware to routes
Route::get('/admin', function () {
    return Theme::view('admin.dashboard');
})->middleware('theme:admin,admin-layout');

// Route groups with theme
Route::group(['middleware' => 'theme:mobile,mobile-layout'], function () {
    Route::get('/mobile', function () {
        return Theme::view('mobile.home');
    });
});
```

## 📤 Export & Import

### Export Themes

```bash
# Export theme to ZIP
php artisan theme:export default

# Export with custom output path
php artisan theme:export default --output=/path/to/backup.zip
```

### Import Themes

```bash
# Import theme from ZIP
php artisan theme:import /path/to/theme.zip

# Import with custom name
php artisan theme:import /path/to/theme.zip --name="my-custom-theme"

# Force import (overwrite existing)
php artisan theme:import /path/to/theme.zip --force
```

### Auto-Backup System

```bash
# Create backup with automatic rotation
php artisan theme:backup default

# Keep specific number of backups
php artisan theme:backup default --keep=10
```

## 📦 Asset Management

### Basic Asset Management

```php
// In your theme config.php or controller
$asset = Theme::asset();

// Add CSS and JS files
$asset->add('bootstrap', 'css/bootstrap.min.css');
$asset->add('jquery', 'js/jquery.min.js', ['bootstrap']);

// Theme-specific assets
$asset->themePath()->add('custom', 'css/custom.css');

// External CDN assets
$asset->add('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
```

### Advanced Asset Features

```php
// CDN Support
$asset->enableCdn('https://cdn.example.com');
$asset->add('bootstrap', 'css/bootstrap.min.css');
$asset->disableCdn();

// Asset Versioning
$asset->addVersioned('app', 'js/app.js');
$asset->addVersioned('style', 'css/style.css', [], '2.0.0');

// Conditional Assets
$asset->addConditional('mobile', 'mobile-css', 'css/mobile.css');
$asset->addConditional('desktop', 'desktop-css', 'css/desktop.css');

// Asset Integrity (SRI)
$asset->addWithIntegrity('bootstrap', 'css/bootstrap.min.css', 'sha384-...');

// Asset Optimization
$asset->optimize(true); // Use minified versions in production
```

### Asset Containers

```php
// Create named containers
$asset->container('footer')->add('footer-script', 'js/footer.js');

// Render specific containers
@scripts('footer')
```

### Inline Assets

```php
// Inline CSS
$asset->writeStyle('custom-style', 'body { background: #f0f0f0; }');

// Inline JavaScript
$asset->writeScript('custom-script', 'console.log("Hello World!");');
```

## 🏗️ Layouts & Views

### Layout System

```php
// Set layout
Theme::layout('admin');

// Multiple layouts
Theme::layout('mobile')->uses('mobile-theme');
```

### View Rendering

```php
// Basic view
Theme::view('home.index', $data);

// With specific theme and layout
Theme::uses('admin')->layout('dashboard')->view('admin.dashboard', $data);

// Scope to theme directory
Theme::scope('home.index', $data)->render();

// Watch both theme and app views
Theme::watch('home.index', $data)->render();
```

### Partials

```php
// Render partial
@partial('header', ['title' => 'Page Header'])

// Sections (from partials/sections/)
@sections('main')

// Partial with layout context
Theme::partialWithLayout('sidebar', ['menu' => $menu]);
```

## 🧩 Widgets

### Creating Widgets

```bash
# Global widget
php artisan theme:widget UserProfile --global

# Theme-specific widget
php artisan theme:widget UserProfile default
```

### Widget Class

```php
namespace App\Widgets;

use Ayra\Theme\Widget;

class WidgetUserProfile extends Widget
{
    public function render($data = [])
    {
        return view('widgets.user-profile', $data);
    }
}
```

### Using Widgets

```php
// In Blade templates
@widget('user-profile', ['user' => $user])

// In PHP
Theme::widget('user-profile', ['user' => $user])->render();
```

## 🍞 Breadcrumbs

### Creating Breadcrumbs

```php
// Simple breadcrumb
Theme::breadcrumb()
    ->add('Home', '/')
    ->add('Products', '/products')
    ->add('Category', '/products/category');

// Array-based
Theme::breadcrumb()->add([
    ['label' => 'Home', 'url' => '/'],
    ['label' => 'Products', 'url' => '/products'],
    ['label' => 'Category', 'url' => '/products/category']
]);
```

### Custom Templates

```php
// Set custom template
Theme::breadcrumb()->setTemplate('
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($crumbs as $i => $crumb)
                @if($i != (count($crumbs) - 1))
                    <li class="breadcrumb-item">
                        <a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active">{{ $crumb["label"] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
');

// Render breadcrumbs
{!! Theme::breadcrumb()->render() !!}
```

## 🎭 Blade Directives

### Available Directives

```php
// Theme data
@get('title')
@getIfHas('description', 'Default description')

// Partials and sections
@partial('header', ['title' => 'Header'])
@sections('main')

// Content
@content()

// Assets
@styles()
@scripts()
@styles('footer')
@scripts('footer')

// Widgets
@widget('user-profile', ['user' => $user])

// Utilities
@protect('email@example.com')
@dd('Debug info')
@d('Debug info')
@dv()
```

## 🛠️ Helper Functions

### Date & Time Helpers

```php
// Format dates
format_date('2024-01-15', 'F j, Y') // January 15, 2024
human_date('2024-01-15') // 2 months ago
time_ago('2024-01-15') // 2 months ago

// Date checks
is_weekend('2024-01-15') // false
is_business_day('2024-01-15') // true

// Age calculation
get_age('1990-05-20') // 33
```

### Formatting Helpers

```php
// Number formatting
format_bytes(1024) // 1 KB
format_number(1500) // 1.5K
format_currency(99.99, 'USD') // $99.99

// Text formatting
slugify('Hello World!') // hello-world
truncate('Long text here...', 10) // Long text...
word_limit('Many words in this sentence', 5) // Many words in this...

// Search highlighting
highlight_search('Hello World', 'world') // Hello <mark>World</mark>
```

### Security & Privacy Helpers

```php
// Password & token generation
generate_password(16, true) // Random secure password
generate_token(32) // Random hex token

// Data masking
mask_email('user@example.com') // us**@ex***.com
mask_phone('+1-555-123-4567') // +1-5**-***-4567

// Email protection
protectEmail('user@example.com') // JavaScript-protected email link
```

### Device & Browser Detection

```php
// Device type
is_mobile() // true/false
is_tablet() // true/false
is_desktop() // true/false

// Browser information
$browser = get_browser_info();
// Returns: ['browser' => 'Chrome', 'version' => '120.0', 'os' => 'Windows']

// Client information
get_client_ip() // Client IP address
get_country_code() // Country code from IP
```

### File & Media Helpers

```php
// File validation
is_image('photo.jpg') // true
is_video('movie.mp4') // true
is_audio('song.mp3') // true

// File utilities
sanitize_filename('My File (1).pdf') // My_File_1.pdf
get_file_extension('document.pdf') // pdf
get_file_size('/path/to/file') // 2.5 MB
```

### Validation Helpers

```php
// Input validation
validate_email('user@example.com') // true
validate_url('https://example.com') // true
validate_ip('192.168.1.1') // true
```

### UI & Design Helpers

```php
// Colors
get_random_color() // #a1b2c3
get_contrast_color('#ffffff') // #000000

// Emojis
get_emoji('smile') // 😊
get_emoji('heart') // ❤️
get_flag_emoji('US') // 🇺🇸

// Gravatar
get_gravatar_url('user@example.com', 200) // Gravatar URL
```

### Testing & Development Helpers

```php
// Random test data
get_random_name() // John Smith
get_random_email() // john.smith@gmail.com
get_random_company() // TechCorp
get_random_phone() // +1-555-123-4567
get_random_address() // 123 Main St, New York, NY 10001
get_random_website() // https://www.example.com

// Random quotes
get_random_quote() // Inspirational quote
```

### SEO & Meta Helpers

```php
// Basic meta tags
meta_init() // Common meta tags

// Custom meta tags
meta_tags([
    'title' => 'Page Title',
    'description' => 'Page description',
    'keywords' => 'laravel, themes'
])

// SEO tags
seo_tags(
    'Page Title',
    'Page description',
    'keywords',
    'Author Name',
    'https://example.com/image.jpg',
    'https://example.com/page'
)
```

### Utility Helpers

```php
// Ordinal numbers
get_ordinal(1) // 1st
get_ordinal(2) // 2nd
get_ordinal(3) // 3rd

// Pluralization
get_plural('category', 1) // category
get_plural('category', 5) // categories

// QR Code & Barcode (requires additional libraries)
generate_qr_code('https://example.com')
generate_barcode('123456789')
```

## 🚀 Advanced Features

### Theme Statistics

```php
// Get all available themes
$themes = Theme::getAvailableThemes();

// Get theme statistics
$stats = Theme::getThemeStats('default');
// Returns: ['views' => 15, 'partials' => 8, 'assets' => 12, 'layouts' => 3, 'widgets' => 5]

// Check theme existence
if (Theme::exists('my-theme')) {
    // Theme exists
}
```

### Theme Preview URLs

```php
// Generate preview URLs
$previewUrl = Theme::getPreviewUrl('dark-theme', '/home');
// Returns: http://yoursite.com/home?theme=dark-theme

$layoutPreviewUrl = Theme::getPreviewUrl('default', '/admin', 'admin-layout');
// Returns: http://yoursite.com/admin?theme=default&layout=admin-layout
```

### Conditional Asset Loading

```php
// Load assets based on conditions
$asset->addConditional('mobile', 'mobile-css', 'css/mobile.css');
$asset->addConditional('desktop', 'desktop-css', 'css/desktop.css');

// In your Blade templates
@if(request()->isMobile())
    @foreach(Theme::asset()->getConditionalAssets('mobile') as $name => $asset)
        <link rel="stylesheet" href="{{ $asset['path'] }}">
    @endforeach
@endif
```

### Asset Optimization

```php
// Enable optimization for production
if (app()->environment('production')) {
    Theme::asset()->optimize(true);
}

// This will automatically use minified versions if they exist
// css/style.css → css/min/style.min.css
```

### Theme Switching Examples

```php
// Switch theme with persistence
Theme::switch('dark-theme', true);

// Switch theme for current request only
Theme::switch('light-theme', false);

// Check current theme
$currentTheme = Theme::getCurrentTheme();

// Check if specific theme is active
if (Theme::isActive('dark-theme')) {
    // Dark theme specific logic
}
```

### Export/Import Examples

```bash
# Export theme
php artisan theme:export default --output=/backups/theme.zip

# Import theme
php artisan theme:import /backups/theme.zip --name="restored-theme" --force

# Create backup with rotation
php artisan theme:backup default --keep=10
```

### Advanced Asset Management

```php
// CDN Support
$asset->enableCdn('https://cdn.example.com');
$asset->add('bootstrap', 'css/bootstrap.min.css');

// Asset Versioning
$asset->addVersioned('app', 'js/app.js');
$asset->addVersioned('style', 'css/style.css', [], '2.0.0');

// Asset Integrity (SRI)
$asset->addWithIntegrity('bootstrap', 'css/bootstrap.min.css', 'sha384-...');

// Conditional Assets
$asset->addConditional('mobile', 'mobile-css', 'css/mobile.css');
$asset->addConditional('desktop', 'desktop-css', 'css/desktop.css');
```

## 📚 Complete Helper Function Reference

### Date & Time Functions
- `format_date($date, $format, $timezone)` - Format date with custom format
- `human_date($date)` - Get human readable date
- `time_ago($timestamp)` - Get time ago from timestamp
- `is_weekend($date)` - Check if date is weekend
- `is_business_day($date)` - Check if date is business day
- `get_age($birthDate)` - Calculate age from birth date

### Formatting Functions
- `format_bytes($bytes, $precision)` - Format bytes to human readable
- `format_number($number, $precision)` - Format number with abbreviations
- `format_currency($amount, $currency, $locale)` - Format currency
- `slugify($text, $separator)` - Create URL-friendly slug
- `truncate($text, $length, $ending)` - Truncate text to length
- `word_limit($text, $limit, $ending)` - Limit text to word count
- `highlight_search($text, $search, $highlight)` - Highlight search terms

### Security Functions
- `generate_password($length, $special_chars)` - Generate random password
- `generate_token($length)` - Generate random token
- `mask_email($email, $mask)` - Mask email for privacy
- `mask_phone($phone, $mask)` - Mask phone for privacy
- `protectEmail($email)` - Protect email from bots

### Device Detection Functions
- `is_mobile()` - Check if request is from mobile
- `is_tablet()` - Check if request is from tablet
- `is_desktop()` - Check if request is from desktop
- `get_browser_info()` - Get browser information
- `get_client_ip()` - Get client IP address
- `get_country_code($ip)` - Get country code from IP

### File Functions
- `sanitize_filename($filename)` - Sanitize filename
- `get_file_extension($filename)` - Get file extension
- `is_image($filename)` - Check if file is image
- `is_video($filename)` - Check if file is video
- `is_audio($filename)` - Check if file is audio
- `get_file_size($filepath)` - Get file size

### Validation Functions
- `validate_email($email)` - Validate email address
- `validate_url($url)` - Validate URL
- `validate_ip($ip)` - Validate IP address

### UI Functions
- `get_random_color()` - Get random color
- `get_contrast_color($hexColor)` - Get contrasting color
- `get_emoji($name)` - Get emoji by name
- `get_flag_emoji($countryCode)` - Get country flag emoji
- `get_gravatar_url($email, $size)` - Get Gravatar URL

### Utility Functions
- `get_ordinal($number)` - Get ordinal suffix
- `get_plural($singular, $count)` - Get plural form
- `get_random_quote()` - Get random inspirational quote
- `get_random_name()` - Get random name for testing
- `get_random_email()` - Get random email for testing
- `get_random_company()` - Get random company for testing

### SEO Functions
- `meta_init()` - Print common meta tags
- `meta_tags($tags)` - Generate meta tags from array
- `seo_tags($title, $description, $keywords, $author, $image, $url)` - Generate SEO meta tags

## 🎯 Usage Examples in Themes

### In Theme Configuration

```php
// public/themes/my-theme/config.php
return [
    'events' => [
        'before' => function($theme) {
            // Set dynamic title with current date
            $theme->setTitle('My Theme - ' . format_date(now(), 'F Y'));
            
            // Set meta tags
            $theme->setDescription('A beautiful theme created on ' . human_date(now()));
            
            // Add conditional assets based on device
            if (is_mobile()) {
                $theme->asset()->add('mobile-css', 'css/mobile.css');
            }
        },
        'asset' => function($asset) {
            // Add versioned assets
            $asset->addVersioned('main', 'css/main.css');
            $asset->addVersioned('app', 'js/app.js');
            
            // Add CDN assets
            $asset->enableCdn('https://cdn.example.com');
            $asset->add('bootstrap', 'css/bootstrap.min.css');
            $asset->disableCdn();
        }
    ]
];
```

### In Blade Templates

```php
{{-- layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    {!! meta_init() !!}
    {!! seo_tags($title ?? 'My Site', $description ?? 'Welcome', $keywords ?? '') !!}
    
    @styles()
    
    {{-- Conditional assets --}}
    @if(is_mobile())
        <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    @endif
</head>
<body>
    <header>
        <h1>{{ $title ?? 'Welcome' }}</h1>
        <p>Last updated: {{ human_date($lastUpdated) }}</p>
        
        {{-- Device-specific content --}}
        @if(is_mobile())
            <div class="mobile-nav">Mobile Navigation</div>
        @elseif(is_tablet())
            <div class="tablet-nav">Tablet Navigation</div>
        @else
            <div class="desktop-nav">Desktop Navigation</div>
        @endif
    </header>
    
    <main>
        @content()
    </main>
    
    <footer>
        <p>&copy; {{ date('Y') }} {{ get_random_company() }}</p>
        <p>Generated in {{ format_bytes(memory_get_peak_usage()) }}</p>
    </footer>
    
    @scripts()
</body>
</html>
```

### In Controllers

```php
namespace App\Http\Controllers;

use Ayra\Theme\Facades\Theme;

class HomeController extends Controller
{
    public function index()
    {
        // Switch theme based on user preference
        if (request()->has('theme')) {
            Theme::switch(request()->get('theme'), true);
        }
        
        // Get theme statistics
        $stats = Theme::getThemeStats(Theme::getCurrentTheme());
        
        // Prepare data with helper functions
        $data = [
            'title' => 'Welcome to ' . get_random_company(),
            'description' => 'A beautiful site created on ' . human_date(now()),
            'stats' => $stats,
            'isMobile' => is_mobile(),
            'browserInfo' => get_browser_info(),
            'randomQuote' => get_random_quote()
        ];
        
        return Theme::view('home.index', $data);
    }
}
```

This comprehensive set of helper functions makes your Laravel Themes package incredibly powerful and user-friendly! Users can now build sophisticated themes with minimal custom code, using these built-in utilities for common tasks.

## 🎓 How to Use - Complete Tutorial

### 🚀 Getting Started - Step by Step

#### 1. **Installation & Setup**

```bash
# Install the package
composer require ayra/laravel-themes

# Publish configuration
php artisan vendor:publish --provider="Ayra\Theme\ThemeServiceProvider"

# Add to .env file
echo "APP_THEME=default" >> .env
echo "APP_THEME_LAYOUT=main" >> .env
echo "APP_THEME_DIR=public/themes" >> .env

# Create your first theme
php artisan theme:create default
```

#### 2. **Basic Theme Structure**

After running `php artisan theme:create default`, you'll have:

```
public/themes/default/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── img/
├── layouts/
│   └── layout.blade.php
├── partials/
│   ├── header.blade.php
│   ├── footer.blade.php
│   └── sections/
│       └── main.blade.php
├── views/
│   └── index.blade.php
├── widgets/
├── theme.json
└── config.php
```

#### 3. **Create Your First Layout**

```php
{{-- public/themes/default/layouts/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Theme::get('title', 'My Website') }}</title>
    
    {!! meta_init() !!}
    @styles()
</head>
<body>
    @partial('header')
    
    <main>
        @content()
    </main>
    
    @partial('footer')
    
    @scripts()
</body>
</html>
```

#### 4. **Create Header Partial**

```php
{{-- public/themes/default/partials/header.blade.php --}}
<header class="site-header">
    <nav class="main-nav">
        <div class="logo">
            <a href="/">{{ Theme::get('site_name', 'My Site') }}</a>
        </div>
        
        <ul class="nav-menu">
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
        
        {{-- Device-specific navigation --}}
        @if(is_mobile())
            <div class="mobile-menu-toggle">☰</div>
        @endif
    </nav>
    
    {{-- Breadcrumbs --}}
    {!! Theme::breadcrumb()->render() !!}
</header>
```

#### 5. **Create Main Content Section**

```php
{{-- public/themes/default/partials/sections/main.blade.php --}}
<section class="main-content">
    <div class="container">
        <h1>{{ $title ?? 'Welcome' }}</h1>
        
        @if(isset($description))
            <p class="lead">{{ $description }}</p>
        @endif
        
        {{-- Show last updated time --}}
        @if(isset($lastUpdated))
            <p class="text-muted">
                <small>Last updated: {{ human_date($lastUpdated) }}</small>
            </p>
        @endif
        
        {{-- Content area --}}
        <div class="content">
            @yield('content')
        </div>
    </div>
</section>
```

#### 6. **Create Footer Partial**

```php
{{-- public/themes/default/partials/footer.blade.php --}}
<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>{{ Theme::get('footer_about', 'A beautiful website built with Laravel Themes.') }}</p>
            </div>
            
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Email: {!! protectEmail('contact@example.com') !!}</p>
                <p>Phone: {{ mask_phone('+1-555-123-4567') }}</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/terms">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ get_random_company() }}. All rights reserved.</p>
            <p>Generated in {{ format_bytes(memory_get_peak_usage()) }}</p>
        </div>
    </div>
</footer>
```

#### 7. **Create Your First View**

```php
{{-- public/themes/default/views/index.blade.php --}}
@extends('theme::layouts.layout')

@section('content')
<div class="welcome-section">
    <h1>{{ $title ?? 'Welcome to Our Site' }}</h1>
    
    @if(isset($description))
        <p class="lead">{{ $description }}</p>
    @endif
    
    {{-- Show random quote --}}
    <blockquote class="inspirational-quote">
        "{{ get_random_quote() }}"
    </blockquote>
    
    {{-- Device-specific content --}}
    @if(is_mobile())
        <div class="mobile-features">
            <h3>Mobile Optimized</h3>
            <p>This site is optimized for mobile devices!</p>
        </div>
    @elseif(is_tablet())
        <div class="tablet-features">
            <h3>Tablet Friendly</h3>
            <p>Perfect for tablet users!</p>
        </div>
    @else
        <div class="desktop-features">
            <h3>Desktop Experience</h3>
            <p>Full desktop experience with advanced features!</p>
        </div>
    @endif
    
    {{-- Theme statistics --}}
    @if(isset($stats))
        <div class="theme-stats">
            <h3>Theme Statistics</h3>
            <ul>
                <li>Views: {{ $stats['views'] }}</li>
                <li>Partials: {{ $stats['partials'] }}</li>
                <li>Assets: {{ $stats['assets'] }}</li>
                <li>Layouts: {{ $stats['layouts'] }}</li>
                <li>Widgets: {{ $stats['widgets'] }}</li>
            </ul>
        </div>
    @endif
</div>
@endsection
```

#### 8. **Configure Your Theme**

```php
{{-- public/themes/default/config.php --}}
<?php

return [
    'events' => [
        'before' => function($theme) {
            // Set dynamic title with current date
            $theme->setTitle('My Beautiful Theme - ' . format_date(now(), 'F Y'));
            
            // Set meta information
            $theme->setDescription('A stunning theme created on ' . human_date(now()));
            $theme->setAuthor('Your Name');
            $theme->setKeywords('laravel, themes, beautiful, responsive');
            
            // Set site information
            $theme->set('site_name', 'My Awesome Site');
            $theme->set('footer_about', 'Building amazing websites with Laravel Themes.');
            
            // Set breadcrumb template
            $theme->breadcrumb()->setTemplate('
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @foreach($crumbs as $i => $crumb)
                            @if($i != (count($crumbs) - 1))
                                <li class="breadcrumb-item">
                                    <a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item active">{{ $crumb["label"] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            ');
        },
        
        'asset' => function($asset) {
            // Add theme-specific assets
            $asset->themePath()->add([
                ['style', 'css/style.css'],
                ['script', 'js/script.js']
            ]);
            
            // Add versioned assets
            $asset->addVersioned('main', 'css/main.css');
            $asset->addVersioned('app', 'js/app.js');
            
            // Add conditional assets based on device
            if (is_mobile()) {
                $asset->addConditional('mobile', 'mobile-css', 'css/mobile.css');
                $asset->addConditional('mobile', 'mobile-js', 'js/mobile.js');
            } elseif (is_tablet()) {
                $asset->addConditional('tablet', 'tablet-css', 'css/tablet.css');
            } else {
                $asset->addConditional('desktop', 'desktop-css', 'css/desktop.css');
                $asset->addConditional('desktop', 'desktop-js', 'js/desktop.js');
            }
            
            // Add CDN assets
            $asset->enableCdn('https://cdnjs.cloudflare.com');
            $asset->add('bootstrap', 'css/bootstrap.min.css');
            $asset->add('jquery', 'js/jquery.min.js');
            $asset->disableCdn();
            
            // Add assets with integrity (SRI)
            $asset->addWithIntegrity('bootstrap', 'css/bootstrap.min.css', 'sha384-...');
        }
    ]
];
```

#### 9. **Create Your Controller**

```php
<?php

namespace App\Http\Controllers;

use Ayra\Theme\Facades\Theme;

class HomeController extends Controller
{
    public function index()
    {
        // Switch theme based on user preference or request
        if (request()->has('theme')) {
            Theme::switch(request()->get('theme'), true);
        }
        
        // Get current theme information
        $currentTheme = Theme::getCurrentTheme();
        $themeStats = Theme::getThemeStats($currentTheme);
        
        // Prepare data with helper functions
        $data = [
            'title' => 'Welcome to ' . get_random_company(),
            'description' => 'A beautiful and responsive website built with Laravel Themes. Created on ' . human_date(now()),
            'lastUpdated' => now(),
            'stats' => $themeStats,
            'isMobile' => is_mobile(),
            'isTablet' => is_tablet(),
            'isDesktop' => is_desktop(),
            'browserInfo' => get_browser_info(),
            'clientIP' => get_client_ip(),
            'countryCode' => get_country_code(),
            'randomQuote' => get_random_quote(),
            'randomName' => get_random_name(),
            'randomEmail' => get_random_email(),
            'randomCompany' => get_random_company()
        ];
        
        return Theme::view('index', $data);
    }
    
    public function about()
    {
        // Set breadcrumbs
        Theme::breadcrumb()
            ->add('Home', '/')
            ->add('About', '/about');
        
        $data = [
            'title' => 'About Us',
            'description' => 'Learn more about our company and mission.',
            'team' => [
                get_random_name(),
                get_random_name(),
                get_random_name()
            ]
        ];
        
        return Theme::view('about', $data);
    }
    
    public function contact()
    {
        // Set breadcrumbs
        Theme::breadcrumb()
            ->add('Home', '/')
            ->add('Contact', '/contact');
        
        $data = [
            'title' => 'Contact Us',
            'description' => 'Get in touch with our team.',
            'contactInfo' => [
                'email' => 'contact@example.com',
                'phone' => '+1-555-123-4567',
                'address' => get_random_address()
            ]
        ];
        
        return Theme::view('contact', $data);
    }
}
```

#### 10. **Add Routes**

```php
{{-- routes/web.php --}}
<?php

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);

// Theme preview routes
Route::get('/preview/{theme}', function($theme) {
    Theme::switch($theme, false);
    return Theme::view('index');
})->middleware('theme.preview');

// Admin routes with specific theme
Route::group(['middleware' => 'theme:admin,admin-layout'], function () {
    Route::get('/admin', function () {
        return Theme::view('admin.dashboard');
    });
});

// Mobile routes with mobile theme
Route::group(['middleware' => 'theme:mobile,mobile-layout'], function () {
    Route::get('/mobile', function () {
        return Theme::view('mobile.home');
    });
});
```

### 🎨 **Advanced Theme Features**

#### **Creating Multiple Themes**

```bash
# Create different themes for different purposes
php artisan theme:create admin
php artisan theme:create mobile
php artisan theme:create corporate
php artisan theme:create blog
```

#### **Theme Switching in Real-Time**

```php
// In your controller or middleware
public function switchTheme(Request $request)
{
    $theme = $request->get('theme');
    
    if (Theme::exists($theme)) {
        Theme::switch($theme, true);
        
        // Redirect back with success message
        return redirect()->back()->with('success', "Theme switched to {$theme}");
    }
    
    return redirect()->back()->with('error', 'Theme not found');
}

// Add theme switcher to your layout
<div class="theme-switcher">
    <h4>Choose Theme:</h4>
    @foreach(Theme::getAvailableThemes() as $themeName => $themeInfo)
        <a href="{{ route('switch.theme', ['theme' => $themeName]) }}" 
           class="theme-option {{ Theme::isActive($themeName) ? 'active' : '' }}">
            {{ $themeInfo['name'] ?? $themeName }}
        </a>
    @endforeach
</div>
```

#### **Creating Widgets**

```bash
# Create a global widget
php artisan theme:widget UserProfile --global

# Create a theme-specific widget
php artisan theme:widget RecentPosts default
```

```php
{{-- app/Widgets/WidgetUserProfile.php --}}
<?php

namespace App\Widgets;

use Ayra\Theme\Widget;

class WidgetUserProfile extends Widget
{
    public function render($data = [])
    {
        $user = $data['user'] ?? auth()->user();
        
        if (!$user) {
            return '';
        }
        
        return view('widgets.user-profile', [
            'user' => $user,
            'lastSeen' => human_date($user->last_seen_at),
            'memberSince' => human_date($user->created_at)
        ]);
    }
}

{{-- resources/views/widgets/user-profile.blade.php --}}
<div class="user-profile-widget">
    <div class="user-avatar">
        <img src="{{ get_gravatar_url($user->email, 100) }}" alt="{{ $user->name }}">
    </div>
    
    <div class="user-info">
        <h4>{{ $user->name }}</h4>
        <p>Member since {{ $memberSince }}</p>
        <p>Last seen {{ $lastSeen }}</p>
    </div>
</div>
```

#### **Using Widgets in Your Views**

```php
{{-- In your Blade templates --}}
<div class="sidebar">
    @widget('user-profile', ['user' => auth()->user()])
    @widget('recent-posts', ['limit' => 5])
</div>
```

### 🔧 **Asset Management Examples**

#### **Advanced Asset Configuration**

```php
// In your theme config.php
'asset' => function($asset) {
    // Enable CDN for production
    if (app()->environment('production')) {
        $asset->enableCdn('https://cdn.example.com');
    }
    
    // Add core assets
    $asset->add('bootstrap', 'css/bootstrap.min.css');
    $asset->add('jquery', 'js/jquery.min.js', ['bootstrap']);
    
    // Add theme assets with versioning
    $asset->addVersioned('main', 'css/main.css');
    $asset->addVersioned('app', 'js/app.js');
    
    // Add conditional assets based on device
    if (is_mobile()) {
        $asset->addConditional('mobile', 'mobile-css', 'css/mobile.css');
        $asset->addConditional('mobile', 'mobile-js', 'js/mobile.js');
    }
    
    // Add assets with integrity
    $asset->addWithIntegrity('bootstrap', 'css/bootstrap.min.css', 'sha384-...');
    
    // Disable CDN
    $asset->disableCdn();
}
```

#### **Asset Containers**

```php
// Create named containers for different sections
$asset->container('header')->add('header-css', 'css/header.css');
$asset->container('footer')->add('footer-js', 'js/footer.js');

// In your Blade templates
@styles('header')
@scripts('footer')
```

### 📱 **Responsive Design with Device Detection**

#### **Device-Specific Content**

```php
{{-- In your Blade templates --}}
@if(is_mobile())
    <div class="mobile-navigation">
        <button class="menu-toggle">☰</button>
        <nav class="mobile-menu">
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
        </nav>
    </div>
@elseif(is_tablet())
    <div class="tablet-navigation">
        <nav class="tablet-menu">
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
        </nav>
    </div>
@else
    <div class="desktop-navigation">
        <nav class="desktop-menu">
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <a href="/blog">Blog</a>
            <a href="/portfolio">Portfolio</a>
        </nav>
    </div>
@endif
```

#### **Device-Specific Assets**

```php
// In your theme config
if (is_mobile()) {
    $asset->addConditional('mobile', 'mobile-css', 'css/mobile.css');
    $asset->addConditional('mobile', 'mobile-js', 'js/mobile.js');
} elseif (is_tablet()) {
    $asset->addConditional('tablet', 'tablet-css', 'css/tablet.css');
} else {
    $asset->addConditional('desktop', 'desktop-css', 'css/desktop.css');
    $asset->addConditional('desktop', 'desktop-js', 'js/desktop.js');
}

// In your Blade templates
@foreach(Theme::asset()->getConditionalAssets('mobile') as $name => $asset)
    <link rel="stylesheet" href="{{ asset($asset['path']) }}">
@endforeach
```

### 🎯 **Real-World Use Cases**

#### **E-commerce Theme**

```php
// Theme switching based on user preference
if (auth()->check() && auth()->user()->theme_preference) {
    Theme::switch(auth()->user()->theme_preference, true);
}

// Seasonal themes
$currentMonth = date('n');
if (in_array($currentMonth, [11, 12])) {
    Theme::switch('christmas', false); // Don't persist seasonal themes
} elseif (in_array($currentMonth, [10])) {
    Theme::switch('halloween', false);
}

// Device-specific product display
if (is_mobile()) {
    $productsPerPage = 6;
    $view = 'mobile.product-grid';
} else {
    $productsPerPage = 12;
    $view = 'desktop.product-grid';
}
```

#### **Blog Theme**

```php
// Dynamic meta tags
$metaTags = [
    'title' => $post->title,
    'description' => truncate($post->excerpt, 160),
    'keywords' => implode(', ', $post->tags->pluck('name')->toArray()),
    'author' => $post->author->name,
    'image' => $post->featured_image,
    'url' => request()->url()
];

// SEO optimization
{!! seo_tags($metaTags['title'], $metaTags['description'], $metaTags['keywords'], $metaTags['author'], $metaTags['image'], $metaTags['url']) !!}

// Reading time estimation
$wordCount = str_word_count(strip_tags($post->content));
$readingTime = ceil($wordCount / 200); // 200 words per minute
```

#### **Corporate Theme**

```php
// Company information
$companyInfo = [
    'name' => get_random_company(),
    'founded' => '1995',
    'employees' => format_number(rand(50, 1000)),
    'revenue' => format_currency(rand(1000000, 10000000), 'USD')
];

// Team member cards
@foreach($team as $member)
    <div class="team-member">
        <img src="{{ get_gravatar_url($member->email, 200) }}" alt="{{ $member->name }}">
        <h3>{{ $member->name }}</h3>
        <p>{{ $member->position }}</p>
        <p>Member since {{ human_date($member->joined_at) }}</p>
    </div>
@endforeach
```

### 🚀 **Performance Optimization**

#### **Asset Optimization**

```php
// Enable optimization in production
if (app()->environment('production')) {
    Theme::asset()->optimize(true);
}

// Use CDN for external assets
$asset->enableCdn('https://cdn.example.com');
$asset->add('bootstrap', 'css/bootstrap.min.css');
$asset->disableCdn();

// Asset versioning for cache busting
$asset->addVersioned('main', 'css/main.css');
```

#### **Conditional Loading**

```php
// Load heavy assets only when needed
if (request()->routeIs('blog.*')) {
    $asset->addConditional('blog', 'blog-css', 'css/blog.css');
    $asset->addConditional('blog', 'blog-js', 'js/blog.js');
}

if (request()->routeIs('admin.*')) {
    $asset->addConditional('admin', 'admin-css', 'css/admin.css');
    $asset->addConditional('admin', 'admin-js', 'js/admin.js');
}
```

### 🔒 **Security Features**

#### **Email Protection**

```php
// Protect email addresses from bots
<p>Contact us at: {!! protectEmail('contact@example.com') !!}</p>

// Mask sensitive information
<p>Phone: {{ mask_phone('+1-555-123-4567') }}</p>
<p>Email: {{ mask_email('user@example.com') }}</p>
```

#### **Asset Integrity**

```php
// Add SRI (Subresource Integrity) for external assets
$asset->addWithIntegrity('bootstrap', 'css/bootstrap.min.css', 'sha384-...');
```

### 📊 **Monitoring & Analytics**

#### **Theme Usage Statistics**

```php
// Get theme statistics
$stats = Theme::getThemeStats('default');

// Display in admin panel
<div class="theme-stats">
    <h3>Theme Statistics</h3>
    <ul>
        <li>Views: {{ $stats['views'] }}</li>
        <li>Partials: {{ $stats['partials'] }}</li>
        <li>Assets: {{ $stats['assets'] }}</li>
        <li>Layouts: {{ $stats['layouts'] }}</li>
        <li>Widgets: {{ $stats['widgets'] }}</li>
    </ul>
</div>

// Track theme usage
$themes = Theme::getAvailableThemes();
foreach ($themes as $themeName => $themeInfo) {
    $usageCount = Theme::getThemeStats($themeName);
    // Store in database for analytics
}
```

### 🎨 **Customization Tips**

#### **Creating Custom Helpers**

```php
// In your theme's config.php or a custom helper file
if (!function_exists('theme_specific_helper')) {
    function theme_specific_helper($value) {
        return 'Theme: ' . $value;
    }
}

// Use in your views
{{ theme_specific_helper('Hello World') }}
```

#### **Extending Theme Classes**

```php
// Create custom theme class
class CustomTheme extends \Ayra\Theme\Theme
{
    public function customMethod()
    {
        return 'Custom functionality';
    }
}

// Register in service provider
$this->app->singleton('theme', function($app) {
    return new CustomTheme($app['config'], $app['events'], $app['view'], $app['asset'], $app['files'], $app['breadcrumb'], $app['manifest']);
});
```

This comprehensive tutorial shows you exactly how to use every feature of the Laravel Themes package! From basic setup to advanced customization, you now have everything you need to build amazing, responsive themes.

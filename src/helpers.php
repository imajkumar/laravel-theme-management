<?php

if (!function_exists('theme')){
	/**
	 * Get the theme instance.
	 *
	 * @param  string  $themeName
	 * @param  string  $layoutName
	 * @return \Ayra\Theme\Theme
	 */
	function theme($themeName = null, $layoutName = null){
		$theme = app('theme');

		if ($themeName){
			$theme->theme($themeName);
		}

		if ($layoutName){
			$theme->layout($layoutName);
		}

		return $theme;
	}
}

if (!function_exists('protectEmail')) {
    /**
     * Protect email address against bots
     *
     * @param string $email
     * @return string
     */
    function protectEmail($email)
    {
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1];
        
        return '<a href="javascript:void(0);" onclick="window.location.href=\'mailto:\' + \'' . $username . '\' + \'@\' + \'' . $domain . '\'">' . $username . '@' . $domain . '</a>';
    }
}


if (!function_exists('meta_init')) {
    /**
     * Print common meta tags
     *
     * @return string
     */
    function meta_init()
    {
        return '<meta charset="utf-8">' .
               '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">' .
               '<meta name="viewport" content="width=device-width, initial-scale=1">';
    }
}

if (!function_exists('meta_tags')) {
    /**
     * Generate meta tags from array
     *
     * @param array $tags
     * @return string
     */
    function meta_tags($tags = [])
    {
        $html = '';
        
        foreach ($tags as $name => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $html .= '<meta ' . $key . '="' . $value . '">' . "\n";
                }
            } else {
                $html .= '<meta name="' . $name . '" content="' . $content . '">' . "\n";
            }
        }
        
        return $html;
    }
}

if (!function_exists('seo_tags')) {
    /**
     * Generate SEO meta tags
     *
     * @param string $title
     * @param string $description
     * @param string $keywords
     * @param string $author
     * @param string $image
     * @param string $url
     * @return string
     */
    function seo_tags($title = '', $description = '', $keywords = '', $author = '', $image = '', $url = '')
    {
        $tags = [];
        
        if ($title) {
            $tags['title'] = $title;
            $tags['og:title'] = $title;
            $tags['twitter:title'] = $title;
        }
        
        if ($description) {
            $tags['description'] = $description;
            $tags['og:description'] = $description;
            $tags['twitter:description'] = $description;
        }
        
        if ($keywords) {
            $tags['keywords'] = $keywords;
        }
        
        if ($author) {
            $tags['author'] = $author;
            $tags['og:author'] = $author;
        }
        
        if ($image) {
            $tags['og:image'] = $image;
            $tags['twitter:image'] = $image;
        }
        
        if ($url) {
            $tags['og:url'] = $url;
            $tags['canonical'] = $url;
        }
        
        return meta_tags($tags);
    }
}

if (!function_exists('format_bytes')) {
    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function format_bytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('format_number')) {
    /**
     * Format number with abbreviations (K, M, B)
     *
     * @param int $number
     * @param int $precision
     * @return string
     */
    function format_number($number, $precision = 1)
    {
        if ($number < 1000) {
            return $number;
        }
        
        if ($number < 1000000) {
            return round($number / 1000, $precision) . 'K';
        }
        
        if ($number < 1000000000) {
            return round($number / 1000000, $precision) . 'M';
        }
        
        return round($number / 1000000000, $precision) . 'B';
    }
}

if (!function_exists('time_ago')) {
    /**
     * Get time ago from timestamp
     *
     * @param string|int $timestamp
     * @return string
     */
    function time_ago($timestamp)
    {
        $time = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);
        $now = time();
        $diff = $now - $time;
        
        if ($diff < 60) {
            return 'just now';
        }
        
        if ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
        }
        
        if ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        }
        
        if ($diff < 2592000) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        }
        
        if ($diff < 31536000) {
            $months = floor($diff / 2592000);
            return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
        }
        
        $years = floor($diff / 31536000);
        return $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
    }
}

if (!function_exists('slugify')) {
    /**
     * Create URL-friendly slug
     *
     * @param string $text
     * @param string $separator
     * @return string
     */
    function slugify($text, $separator = '-')
    {
        // Convert to lowercase
        $text = strtolower($text);
        
        // Replace non-alphanumeric characters with separator
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        
        // Replace spaces and multiple separators with single separator
        $text = preg_replace('/[\s-]+/', $separator, $text);
        
        // Remove leading/trailing separators
        return trim($text, $separator);
    }
}

if (!function_exists('truncate')) {
    /**
     * Truncate text to specified length
     *
     * @param string $text
     * @param int $length
     * @param string $ending
     * @return string
     */
    function truncate($text, $length = 100, $ending = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . $ending;
    }
}

if (!function_exists('word_limit')) {
    /**
     * Limit text to specified number of words
     *
     * @param string $text
     * @param int $limit
     * @param string $ending
     * @return string
     */
    function word_limit($text, $limit = 10, $ending = '...')
    {
        $words = explode(' ', $text);
        
        if (count($words) <= $limit) {
            return $text;
        }
        
        return implode(' ', array_slice($words, 0, $limit)) . $ending;
    }
}

if (!function_exists('highlight_search')) {
    /**
     * Highlight search terms in text
     *
     * @param string $text
     * @param string $search
     * @param string $highlight
     * @return string
     */
    function highlight_search($text, $search, $highlight = '<mark>$0</mark>')
    {
        if (empty($search)) {
            return $text;
        }
        
        return preg_replace('/(' . preg_quote($search, '/') . ')/i', $highlight, $text);
    }
}

if (!function_exists('generate_password')) {
    /**
     * Generate random password
     *
     * @param int $length
     * @param bool $special_chars
     * @return string
     */
    function generate_password($length = 12, $special_chars = true)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        
        if ($special_chars) {
            $chars .= '!@#$%^&*()_+-=[]{}|;:,.<>?';
        }
        
        $password = '';
        $char_length = strlen($chars);
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $char_length - 1)];
        }
        
        return $password;
    }
}

if (!function_exists('generate_token')) {
    /**
     * Generate random token
     *
     * @param int $length
     * @return string
     */
    function generate_token($length = 32)
    {
        return bin2hex(random_bytes($length / 2));
    }
}

if (!function_exists('mask_email')) {
    /**
     * Mask email address for privacy
     *
     * @param string $email
     * @param string $mask
     * @return string
     */
    function mask_email($email, $mask = '*')
    {
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1];
        
        $masked_username = substr($username, 0, 2) . str_repeat($mask, strlen($username) - 2);
        $masked_domain = substr($domain, 0, 1) . str_repeat($mask, strlen($domain) - 2) . substr($domain, -1);
        
        return $masked_username . '@' . $masked_domain;
    }
}

if (!function_exists('mask_phone')) {
    /**
     * Mask phone number for privacy
     *
     * @param string $phone
     * @param string $mask
     * @return string
     */
    function mask_phone($phone, $mask = '*')
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $length = strlen($phone);
        
        if ($length <= 4) {
            return str_repeat($mask, $length);
        }
        
        return substr($phone, 0, 2) . str_repeat($mask, $length - 4) . substr($phone, -2);
    }
}

if (!function_exists('is_mobile')) {
    /**
     * Check if request is from mobile device
     *
     * @return bool
     */
    function is_mobile()
    {
        $user_agent = request()->header('User-Agent');
        
        return preg_match('/(android|iphone|ipad|mobile|tablet)/i', $user_agent);
    }
}

if (!function_exists('is_tablet')) {
    /**
     * Check if request is from tablet device
     *
     * @return bool
     */
    function is_tablet()
    {
        $user_agent = request()->header('User-Agent');
        
        return preg_match('/(ipad|tablet)/i', $user_agent);
    }
}

if (!function_exists('is_desktop')) {
    /**
     * Check if request is from desktop device
     *
     * @return bool
     */
    function is_desktop()
    {
        return !is_mobile() && !is_tablet();
    }
}

if (!function_exists('get_browser_info')) {
    /**
     * Get browser information
     *
     * @return array
     */
    function get_browser_info()
    {
        $user_agent = request()->header('User-Agent');
        
        $browser = 'Unknown';
        $version = 'Unknown';
        $os = 'Unknown';
        
        // Browser detection
        if (preg_match('/MSIE|Trident/i', $user_agent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $user_agent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/i', $user_agent)) {
            $browser = 'Edge';
        }
        
        // Version detection
        if (preg_match('/' . $browser . '\/([0-9.]+)/i', $user_agent, $matches)) {
            $version = $matches[1];
        }
        
        // OS detection
        if (preg_match('/Windows/i', $user_agent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac/i', $user_agent)) {
            $os = 'macOS';
        } elseif (preg_match('/Linux/i', $user_agent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $user_agent)) {
            $os = 'Android';
        } elseif (preg_match('/iOS/i', $user_agent)) {
            $os = 'iOS';
        }
        
        return [
            'browser' => $browser,
            'version' => $version,
            'os' => $os,
            'user_agent' => $user_agent
        ];
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * Get client IP address
     *
     * @return string
     */
    function get_client_ip()
    {
        $ip_keys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return request()->ip();
    }
}

if (!function_exists('get_country_code')) {
    /**
     * Get country code from IP (basic implementation)
     *
     * @param string $ip
     * @return string
     */
    function get_country_code($ip = null)
    {
        $ip = $ip ?: get_client_ip();
        
        // This is a basic implementation
        // For production, consider using a service like MaxMind GeoIP2
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
            // You can integrate with external services here
            return 'US'; // Default fallback
        }
        
        return 'Unknown';
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format currency amount
     *
     * @param float $amount
     * @param string $currency
     * @param string $locale
     * @return string
     */
    function format_currency($amount, $currency = 'USD', $locale = 'en_US')
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date with custom format
     *
     * @param string|Carbon $date
     * @param string $format
     * @param string $timezone
     * @return string
     */
    function format_date($date, $format = 'Y-m-d H:i:s', $timezone = null)
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        if ($timezone) {
            $date->setTimezone($timezone);
        }
        
        return $date->format($format);
    }
}

if (!function_exists('human_date')) {
    /**
     * Get human readable date
     *
     * @param string|Carbon $date
     * @return string
     */
    function human_date($date)
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        return $date->diffForHumans();
    }
}

if (!function_exists('is_weekend')) {
    /**
     * Check if date is weekend
     *
     * @param string|Carbon $date
     * @return bool
     */
    function is_weekend($date = null)
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        $date = $date ?: \Carbon\Carbon::now();
        
        return $date->isWeekend();
    }
}

if (!function_exists('is_business_day')) {
    /**
     * Check if date is business day
     *
     * @param string|Carbon $date
     * @return bool
     */
    function is_business_day($date = null)
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        $date = $date ?: \Carbon\Carbon::now();
        
        return !$date->isWeekend();
    }
}

if (!function_exists('get_age')) {
    /**
     * Calculate age from birth date
     *
     * @param string|Carbon $birthDate
     * @return int
     */
    function get_age($birthDate)
    {
        if (is_string($birthDate)) {
            $birthDate = \Carbon\Carbon::parse($birthDate);
        }
        
        return $birthDate->age;
    }
}

if (!function_exists('validate_email')) {
    /**
     * Validate email address
     *
     * @param string $email
     * @return bool
     */
    function validate_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('validate_url')) {
    /**
     * Validate URL
     *
     * @param string $url
     * @return bool
     */
    function validate_url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}

if (!function_exists('validate_ip')) {
    /**
     * Validate IP address
     *
     * @param string $ip
     * @return bool
     */
    function validate_ip($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
}

if (!function_exists('sanitize_filename')) {
    /**
     * Sanitize filename for safe storage
     *
     * @param string $filename
     * @return string
     */
    function sanitize_filename($filename)
    {
        // Remove or replace dangerous characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Remove multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);
        
        // Remove leading/trailing underscores
        $filename = trim($filename, '_');
        
        return $filename;
    }
}

if (!function_exists('get_file_extension')) {
    /**
     * Get file extension
     *
     * @param string $filename
     * @return string
     */
    function get_file_extension($filename)
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }
}

if (!function_exists('is_image')) {
    /**
     * Check if file is an image
     *
     * @param string $filename
     * @return bool
     */
    function is_image($filename)
    {
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(get_file_extension($filename), $extensions);
    }
}

if (!function_exists('is_video')) {
    /**
     * Check if file is a video
     *
     * @param string $filename
     * @return bool
     */
    function is_video($filename)
    {
        $extensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
        return in_array(get_file_extension($filename), $extensions);
    }
}

if (!function_exists('is_audio')) {
    /**
     * Check if file is an audio file
     *
     * @param string $filename
     * @return bool
     */
    function is_audio($filename)
    {
        $extensions = ['mp3', 'wav', 'ogg', 'flac', 'aac', 'wma'];
        return in_array(get_file_extension($filename), $extensions);
    }
}

if (!function_exists('get_file_size')) {
    /**
     * Get file size in human readable format
     *
     * @param string $filepath
     * @return string
     */
    function get_file_size($filepath)
    {
        if (!file_exists($filepath)) {
            return '0 B';
        }
        
        return format_bytes(filesize($filepath));
    }
}

if (!function_exists('generate_qr_code')) {
    /**
     * Generate QR code data URL (basic implementation)
     *
     * @param string $data
     * @param int $size
     * @return string
     */
    function generate_qr_code($data, $size = 200)
    {
        // This is a placeholder - you'll need to install a QR code library
        // For example: composer require endroid/qr-code
        
        // For now, return a placeholder
        return 'data:image/svg+xml;base64,' . base64_encode('<svg width="' . $size . '" height="' . $size . '"><rect width="100%" height="100%" fill="#f0f0f0"/><text x="50%" y="50%" text-anchor="middle" dy=".3em">QR Code</text></svg>');
    }
}

if (!function_exists('generate_barcode')) {
    /**
     * Generate barcode data URL (basic implementation)
     *
     * @param string $data
     * @param int $width
     * @param int $height
     * @return string
     */
    function generate_barcode($data, $width = 200, $height = 100)
    {
        // This is a placeholder - you'll need to install a barcode library
        // For example: composer require milon/barcode
        
        // For now, return a placeholder
        return 'data:image/svg+xml;base64,' . base64_encode('<svg width="' . $width . '" height="' . $height . '"><rect width="100%" height="100%" fill="#f0f0f0"/><text x="50%" y="50%" text-anchor="middle" dy=".3em">Barcode</text></svg>');
    }
}

if (!function_exists('get_random_color')) {
    /**
     * Get random color in hex format
     *
     * @return string
     */
    function get_random_color()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('get_contrast_color')) {
    /**
     * Get contrasting color (black or white) for given background color
     *
     * @param string $hexColor
     * @return string
     */
    function get_contrast_color($hexColor)
    {
        // Remove # if present
        $hexColor = ltrim($hexColor, '#');
        
        // Convert to RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        
        // Calculate luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        // Return black for light backgrounds, white for dark backgrounds
        return $luminance > 0.5 ? '#000000' : '#FFFFFF';
    }
}

if (!function_exists('get_gravatar_url')) {
    /**
     * Get Gravatar URL for email
     *
     * @param string $email
     * @param int $size
     * @param string $default
     * @param string $rating
     * @return string
     */
    function get_gravatar_url($email, $size = 80, $default = 'mp', $rating = 'g')
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d={$default}&r={$rating}";
    }
}

if (!function_exists('get_favicon_url')) {
    /**
     * Get favicon URL for domain
     *
     * @param string $domain
     * @return string
     */
    function get_favicon_url($domain)
    {
        return "https://www.google.com/s2/favicons?domain={$domain}&sz=32";
    }
}

if (!function_exists('get_screenshot_url')) {
    /**
     * Get website screenshot URL (using external service)
     *
     * @param string $url
     * @param int $width
     * @param int $height
     * @return string
     */
    function get_screenshot_url($url, $width = 1200, $height = 800)
    {
        // This uses a free screenshot service - for production, consider paid alternatives
        return "https://api.apiflash.com/v1/urltoimage?access_key=YOUR_API_KEY&url={$url}&width={$width}&height={$height}";
    }
}

if (!function_exists('get_weather_icon')) {
    /**
     * Get weather icon URL (basic implementation)
     *
     * @param string $condition
     * @param string $size
     * @return string
     */
    function get_weather_icon($condition, $size = '64x64')
    {
        // This is a placeholder - you can integrate with weather APIs
        $icons = [
            'sunny' => '☀️',
            'cloudy' => '☁️',
            'rainy' => '🌧️',
            'snowy' => '❄️',
            'stormy' => '⛈️'
        ];
        
        return $icons[$condition] ?? '🌤️';
    }
}

if (!function_exists('get_emoji')) {
    /**
     * Get emoji by name
     *
     * @param string $name
     * @return string
     */
    function get_emoji($name)
    {
        $emojis = [
            'smile' => '😊',
            'heart' => '❤️',
            'thumbs_up' => '👍',
            'thumbs_down' => '👎',
            'check' => '✅',
            'cross' => '❌',
            'warning' => '⚠️',
            'info' => 'ℹ️',
            'star' => '⭐',
            'fire' => '🔥',
            'rocket' => '🚀',
            'money' => '💰',
            'gift' => '🎁',
            'party' => '🎉',
            'music' => '🎵',
            'camera' => '📷',
            'phone' => '📱',
            'computer' => '💻',
            'car' => '🚗',
            'plane' => '✈️'
        ];
        
        return $emojis[$name] ?? '❓';
    }
}

if (!function_exists('get_flag_emoji')) {
    /**
     * Get country flag emoji
     *
     * @param string $countryCode
     * @return string
     */
    function get_flag_emoji($countryCode)
    {
        $countryCode = strtoupper($countryCode);
        
        // Convert country code to regional indicator symbols
        $flag = '';
        for ($i = 0; $i < strlen($countryCode); $i++) {
            $flag .= mb_chr(ord($countryCode[$i]) + 127397);
        }
        
        return $flag;
    }
}

if (!function_exists('get_ordinal')) {
    /**
     * Get ordinal suffix for number
     *
     * @param int $number
     * @return string
     */
    function get_ordinal($number)
    {
        $suffixes = ['th', 'st', 'nd', 'rd'];
        $suffix = $suffixes[$number % 10] ?? 'th';
        
        if ($number >= 11 && $number <= 13) {
            $suffix = 'th';
        }
        
        return $number . $suffix;
    }
}

if (!function_exists('get_plural')) {
    /**
     * Get plural form of word
     *
     * @param string $singular
     * @param int $count
     * @return string
     */
    function get_plural($singular, $count)
    {
        if ($count == 1) {
            return $singular;
        }
        
        // Basic English pluralization rules
        $rules = [
            '/([^aeiouy]|qu)y$/i' => '$1ies',
            '/([^aeiouy]|qu)ies$/i' => '$1ies',
            '/(?:([^f]|f(?!e|o|u|y))|([^f]|f(?!e|o|u|y))s)$/i' => '$1$2s',
            '/([^aeiouy]|qu)o$/i' => '$1oes',
            '/([^aeiouy]|qu)oes$/i' => '$1oes',
            '/([^aeiouy]|qu)um$/i' => '$1a',
            '/([^aeiouy]|qu)a$/i' => '$1a',
            '/([^aeiouy]|qu)us$/i' => '$1i',
            '/([^aeiouy]|qu)i$/i' => '$1i',
            '/([^aeiouy]|qu)ex$/i' => '$1ices',
            '/([^aeiouy]|qu)ices$/i' => '$1ices',
            '/([^aeiouy]|qu)ix$/i' => '$1ices',
            '/([^aeiouy]|qu)is$/i' => '$1es',
            '/([^aeiouy]|qu)es$/i' => '$1es'
        ];
        
        foreach ($rules as $pattern => $replacement) {
            if (preg_match($pattern, $singular)) {
                return preg_replace($pattern, $replacement, $singular);
            }
        }
        
        return $singular . 's';
    }
}

if (!function_exists('get_random_quote')) {
    /**
     * Get random inspirational quote
     *
     * @return string
     */
    function get_random_quote()
    {
        $quotes = [
            "The only way to do great work is to love what you do. - Steve Jobs",
            "Innovation distinguishes between a leader and a follower. - Steve Jobs",
            "Stay hungry, stay foolish. - Steve Jobs",
            "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt",
            "Success is not final, failure is not fatal: it is the courage to continue that counts. - Winston Churchill",
            "The only limit to our realization of tomorrow will be our doubts of today. - Franklin D. Roosevelt",
            "Believe you can and you're halfway there. - Theodore Roosevelt",
            "It does not matter how slowly you go as long as you do not stop. - Confucius",
            "The journey of a thousand miles begins with one step. - Lao Tzu",
            "What you get by achieving your goals is not as important as what you become by achieving your goals. - Zig Ziglar"
        ];
        
        return $quotes[array_rand($quotes)];
    }
}

if (!function_exists('get_random_name')) {
    /**
     * Get random name for testing
     *
     * @return string
     */
    function get_random_name()
    {
        $firstNames = ['John', 'Jane', 'Mike', 'Sarah', 'David', 'Lisa', 'Tom', 'Emma', 'Chris', 'Anna'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
        
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }
}

if (!function_exists('get_random_email')) {
    /**
     * Get random email for testing
     *
     * @return string
     */
    function get_random_email()
    {
        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'example.com'];
        $name = strtolower(str_replace(' ', '.', get_random_name()));
        $domain = $domains[array_rand($domains)];
        
        return $name . '@' . $domain;
    }
}

if (!function_exists('get_random_phone')) {
    /**
     * Get random phone number for testing
     *
     * @return string
     */
    function get_random_phone()
    {
        return '+1-' . rand(200, 999) . '-' . rand(200, 999) . '-' . rand(1000, 9999);
    }
}

if (!function_exists('get_random_address')) {
    /**
     * Get random address for testing
     *
     * @return string
     */
    function get_random_address()
    {
        $streets = ['Main St', 'Oak Ave', 'Elm St', 'Pine Rd', 'Cedar Ln', 'Maple Dr', 'Birch Way', 'Willow Ct'];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego'];
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ', 'PA', 'TX', 'CA'];
        
        $street = rand(100, 9999) . ' ' . $streets[array_rand($streets)];
        $city = $cities[array_rand($cities)];
        $state = $states[array_rand($states)];
        $zip = rand(10000, 99999);
        
        return $street . ', ' . $city . ', ' . $state . ' ' . $zip;
    }
}

if (!function_exists('get_random_company')) {
    /**
     * Get random company name for testing
     *
     * @return string
     */
    function get_random_company()
    {
        $companies = [
            'TechCorp', 'InnovateLabs', 'Digital Solutions', 'Future Systems', 'Smart Technologies',
            'Global Innovations', 'Creative Solutions', 'Advanced Systems', 'Modern Tech', 'NextGen Corp'
        ];
        
        return $companies[array_rand($companies)];
    }
}

if (!function_exists('get_random_website')) {
    /**
     * Get random website URL for testing
     *
     * @return string
     */
    function get_random_website()
    {
        $domains = ['example.com', 'test.org', 'demo.net', 'sample.co', 'mock.io'];
        $domain = $domains[array_rand($domains)];
        
        return 'https://www.' . $domain;
    }
}
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Video Storage Setup
    |--------------------------------------------------------------------------
    |
    | This configuration defines how videos are handled and stored within
    | the application. It separates temporary storage from streaming storage
    | to optimize performance, security, and delivery.
    |
    | Keys:
    |   'temp'    : The disk used for temporary storage of uploaded videos.
    |               Typically 'local' for server-side processing before encoding.
    |               Example: 'local' uses storage/app by default.
    |
    |   'stream'  : The disk used for storing processed HLS streams and
    |               final video outputs. This can be a public disk, or
    |               cloud storage like S3, DigitalOcean Spaces, or GCS.
    |               Example: 'public' uses storage/app/public by default.
    |
    */
    'videos' => [
        'temp'     => 'temp',
        'stream'   => 'videos',
        'extension' => '.mp4',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Storage Disk
    |--------------------------------------------------------------------------
    |
    | This option defines the default filesystem disk that will be used
    | by the application. You can set this to any disk defined in
    | your "filesystems.php" config file.
    |
    */

    'disk' => env('APP_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Referral Configuration
    |--------------------------------------------------------------------------
    |
    | These values are used to calculate referral rewards. You can define
    | the default commission (%) for the referrer, and discount (%) for
    | the referred user.
    |
    */

    'referral' => [
        'commission' => 15,  // Referrer gets 15% commission
        'discount'   => 10,  // Referred user gets 10% discount
    ],

    /*
    |--------------------------------------------------------------------------
    | Payout Configuration
    |--------------------------------------------------------------------------
    |
    | Default fee (in percentage or flat amount) for processing payouts.
    | This value can be used when deducting fees from user withdrawals.
    |
    */

    'payout' => [
        'default_fee' => 5, // 5% or flat 5 units depending on logic
    ],

    /*
    |--------------------------------------------------------------------------
    | Application URLs for Frontend, Admin, and CDN
    |--------------------------------------------------------------------------
    |
    | These URLs define the origins used by the application across different
    | platforms — such as frontend Nuxt app, admin dashboard, and CDN.
    | Useful for CORS setup and URL generation.
    |
    */

    'client_url' => env('CLIENT_URL', 'http://localhost:3000'),
    'client_domain' => env('CLIENT_DOMAIN', 'localhost:3000'),


    /*
    |--------------------------------------------------------------------------
    | SMS Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the SMS gateway service used to send text messages
    | (e.g., OTPs, notifications). These credentials and base URL are used
    | by services like BulkSMSBD or similar.
    |
    | Supported Keys:
    | - base_url:   The root API endpoint of the SMS gateway
    | - api_key:    The private API key for authentication
    | - sender_id:  The sender name/ID that appears in the message
    | - type:       The message format (e.g., 'text', 'unicode')
    |
    | Example usage:
    | Http::baseUrl(config('app.sms.base_url'))->post('/api/smsapi', [...])
    |
    */

    'sms' => [
        'base_url'   => env('SMS_BASE_URL', 'https://bulksmsbd.net'),
        'api_key'    => env('SMS_API_KEY'),
        'sender_id'  => env('SMS_SENDER_ID', 'SENDER'),
        'type'       => env('SMS_TYPE', 'text'),
        'enabled'       => env('SMS_ENABLED', false),
    ],



    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),


    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => 'Asia/Dhaka',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];

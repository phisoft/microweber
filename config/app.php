<?php return array (
  'debug' => true,
  'url' => 'http://localhost/',
  'timezone' => 'UTC',
  'locale' => 'en',
  'fallback_locale' => 'en',
  'key' => 'base64:WGIxaHM3QVp4eG51SVhHa2Q4UkpOQ3QydHdZcGNKOFI=',
  'cipher' => 'AES-256-CBC',
  'log' => 'daily',
  'providers' => 
  array (
    0 => 'Microweber\\App\\Providers\\AppServiceProvider',
    1 => 'Microweber\\App\\Providers\\EventServiceProvider',
    2 => 'Microweber\\App\\Providers\\RouteServiceProvider',
    3 => 'Microweber\\MicroweberServiceProvider',
  ),
  'manifest' => storage_path().DIRECTORY_SEPARATOR.'framework',
);
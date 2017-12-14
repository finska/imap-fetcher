<?php
return [
    'host'          => env('IMAP_HOST'),
    'port'          => env('IMAP_PORT'),
    'encryption'    => env('IMAP_ENCRYPTION'), // Supported: false, 'ssl', 'tls'
    'validate_cert' => true,
    'username'      => env('IMAP_USERNAME'),
    'password'      => env('IMAP_PASSWORD')];
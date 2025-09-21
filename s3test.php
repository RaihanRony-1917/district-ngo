<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;

$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'ap-southeast-1',
    'endpoint' => 'https://wojwjhpqdzjpxwdjxluq.supabase.co/storage/v1/s3',
    'use_path_style_endpoint' => true,
    'credentials' => [
        'key' => 'YOUR_SERVICE_ROLE_KEY',
        'secret' => 'YOUR_SERVICE_ROLE_KEY',
    ],
]);

$result = $s3->putObject([
    'Bucket' => 'ngo',
    'Key' => 'test.txt',
    'Body' => 'Hello Supabase!',
]);

print_r($result);

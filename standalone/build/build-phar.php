<?php
$srcPath  = __DIR__ . '/../lib';
$pharPath = __DIR__ . '/MailControl.phar';

if (file_exists($pharPath)) {
    unlink($pharPath);
}

$phar = new Phar($pharPath, Phar::CURRENT_AS_FILEINFO, basename($pharPath));
$phar->buildFromDirectory($srcPath, '/\.php$/');
$phar->setStub($phar->createDefaultStub('stub.php'));

require $pharPath;
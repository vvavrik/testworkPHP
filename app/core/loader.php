<?php

/*
 * Autoload all project's files
 * to add autoloader: >>require_once __DIR__ . '/../system/autoloader.php';<<
 */

function autoload($className) {

    $pieces = explode('\\', $className);
    $addr = __ROOT__ . 'app/' . implode(DIRECTORY_SEPARATOR, $pieces) . '.php';

    if (file_exists($addr)) {
        require_once ($addr);
    }
    else {
        throw new Exception('Can`t find class "'.$className.'" file at '. __FILE__);
        exit;
    }
}

spl_autoload_register('autoload', true, true);

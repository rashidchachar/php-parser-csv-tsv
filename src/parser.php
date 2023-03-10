<?php

namespace Parser;

require_once 'vendor/autoload.php';

use Parser\Controllers\ProductController;

try {
    $options = getopt("f:u:");
    if (!isset($options['f'])) {
        throw new \Exception("File path is required.");
    }
    if (!isset($options['u'])) {
        throw new \Exception("Unique Combination path is required.");
    }

    $filePath = $options['f'];
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);

    if (!file_exists($filePath)) {
        throw new \Exception("File not found.");
    }

    $controller = new ProductController();

    switch ($extension) {
        case 'csv':
            $controller->parseCSV($filePath);
            break;
        case 'tsv':
            $controller->parseTSV($filePath);
            break;
        default:
            throw new \Exception("Invalid file format.");
    }
    $uniquePath = $options['u'];
    $controller->saveUniqueCombinations($uniquePath);

    echo "Parsing completed successfully.";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
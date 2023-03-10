<?php

namespace Parser\Controllers;

use Parser\Models\CombinationModel;

class ProductController
{
    private $products;
    private $uniqueCombinations;

    private $headers;
    public function __construct()
    {
        $this->products = array();
        $this->uniqueCombinations = array();
        $this->headers = array();
    }

    public function parseCSV($filePath)
    {
        $fh = fopen($filePath, "r");
        if (!$fh) {
            throw new \Exception("Cannot open file.");
        }

        $headers = fgetcsv($fh);
        if (!$headers) {
            throw new \Exception("Cannot read file headers.");
        }
        $this->headers = $headers;
        while (($row = fgetcsv($fh)) !== false) {
            if (count($row) != count($headers)) {
                throw new \Exception("Invalid row format.");
            }

            $product = [];

            foreach ($headers as $i => $header) {
                $value = trim($row[$i]);
                if ($value === "") {
                    throw new \Exception("Missing required field: " . $header);
                }
                $product[$header] = $value;
            }
            print_r($product);
            $this->products[] = $product;
        }

        fclose($fh);
    }

    public function parseTSV($filePath)
    {
        $fh = fopen($filePath, "r");
        if (!$fh) {
            throw new \Exception("Cannot open file.");
        }

        $headers = explode("\t", trim(fgets($fh)));
        if (!$headers) {
            throw new \Exception("Cannot read file headers.");
        }
        $this->headers = $headers;

        while (($line = fgets($fh)) !== false) {
            $row = explode("\t", trim($line));
            if (count($row) != count($headers)) {
                throw new \Exception("Invalid row format.");
            }

            $product = [];

            foreach ($headers as $i => $header) {
                $value = trim($row[$i]);
                if ($value === "") {
                    throw new \Exception("Missing required field: " . $header);
                }
                $product[$header] = $value;
            }

            $this->products[] = $product;
            print_r($product);
        }

        fclose($fh);
    }


    public function saveUniqueCombinations($filePath = "unique_combinations.csv")
    {
        $combinationModel = new CombinationModel($this->products);
        $this->uniqueCombinations = $combinationModel->getUniqueCombinations();
        $fh = fopen($filePath, "w");
        if (!$fh) {
            throw new \Exception("Cannot open file for writing.");
        }

        $headers = $this->headers;
        $headers[] = 'count';

        fputcsv($fh,$headers );
        foreach ($this->uniqueCombinations as $combination) {
            fputcsv($fh, $combination);
        }

        fclose($fh);
    }
}
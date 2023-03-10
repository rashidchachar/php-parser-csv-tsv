<?php
namespace Parser\Models;

class CombinationModel
{
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function getUniqueCombinations()
    {
        $uniqueCombinations = [];

        // Iterate over each Product object
        foreach ($this->products as $product) {
            $hash = '';
            foreach ($product as $key => $value)
            {
                $hash .= $value;
            }
            // Create a hash of the product attributes to use as the unique key
            $hash = md5($hash);

            // Increment the count of this combination, or add a new entry if it doesn't exist yet
            if (isset($uniqueCombinations[$hash])) {
                if(!isset($uniqueCombinations[$hash]['count']))
                {
                    $uniqueCombinations[$hash]['count'] = 2;
                }
                else{
                    $uniqueCombinations[$hash]['count'] = $uniqueCombinations[$hash]['count']+1;
                }
            } else {
                $uniqueCombinations[$hash] = $product;
            }
        }

        return array_values($uniqueCombinations);
    }
}
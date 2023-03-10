<?php
namespace Parser\Models;

class UniqueCombinations
{
    private $uniqueCombinations;

    public function __construct()
    {
        $this->uniqueCombinations = [];
    }

    public function addCombination(array $combination): void
    {
        $key = implode('-', $combination);
        if (!isset($this->uniqueCombinations[$key])) {
            $this->uniqueCombinations[$key] = [
                'combination' => $combination,
                'count' => 1,
            ];
        } else {
            $this->uniqueCombinations[$key]['count']++;
        }
    }

    public function getUniqueCombination(){
        return $this->uniqueCombinations;
    }

    public function saveToFile(string $filePath): void
    {
        $file = fopen($filePath, 'w');
        if (!$file) {
            throw new Exception('Failed to open file for writing.');
        }

        fputcsv($file, array_merge(['count'], array_keys($this->uniqueCombinations[array_key_first($this->uniqueCombinations)]['combination'])));

        foreach ($this->uniqueCombinations as $combination) {
            fputcsv($file, array_merge([$combination['count']], $combination['combination']));
        }

        fclose($file);
    }
}
<?php

namespace App\Service;

use App\Entity\Product; 

class ProductService {
  const FIELDS_COUNT = 6;  // start counting from 1, i.e. same as count()

  /**
   * @return Product[]
   */
  public static function readProductsFromCsv(string $csvFilePath) {
    $products = [
      'erroneous' => [],
      'correct' => []
    ];

    $csvFilePointer = fopen($csvFilePath, 'r');
    fgetcsv($csvFilePointer);  // skip first row with field names
    while ($csvRow = fgetcsv($csvFilePointer)) {
      // check for errors
      if (count($csvRow) !== self::FIELDS_COUNT) {
        $products['erroneous'][] = $csvRow;
      } else {
        $product = new Product();
        $product->setCode($csvRow[0]); 
        $product->setName($csvRow[1]);
        $product->setDescription($csvRow[2]);
        $product->setStock($csvRow[3]);
        $product->setPrice($csvRow[4]);
        
        $productPriceFloat = self::convertProductPriceToFloat($product->getPrice());
        if ($productPriceFloat < 5 && $product->getStock() < 10) {
          $products['erroneous'][] = $product;
        } else if ($productPriceFloat > 1000) {
          $products['erroneous'][] = $product;
          // TODO: discontinued business logic
        } else {
          $products['correct'][] = $product;
        }
      }
    }

    return $products;
  }

  // We use this function to surely convert to float because price might be something like "$4.33",
  // which produces zero (0) if used only with (float) cast
  public static function convertProductPriceToFloat(string $price): float {
    $filteredString = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    return (float) $filteredString;
  }
}
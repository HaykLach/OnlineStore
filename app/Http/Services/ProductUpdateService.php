<?php

namespace App\Http\Services;


use App\Exceptions\ProductLimitException;
use App\Models\Product;

class ProductUpdateService
{
    /**
     * Update product method
     * @param array $data
     * @return array
     * @throws ProductLimitException
     */
    public function updateProduct(array $data)
    {
        $isMulti = $this->getProductInfoType($data);
        $finalRes = [];

        if ($isMulti) {
            if (count($data) > 1000) {
                throw new ProductLimitException("You have exceed maximum product information limit in one request");
            }

            foreach ($data as $product_info) {
                $product_id = $product_info['product_id'];
                $row = [
                    'product_id' => $product_id,
                ];
                foreach ($product_info['prices'] as $region_id => $price) {
                    $row['prices'][$region_id] = $this->processUpdate($product_id, $region_id, $price);
                }
                $finalRes[] = $row;
            }
        } else {
            $product_id = $data['product_id'];
            $finalRes = [
                'product_id' => $product_id,
            ];
            foreach ($data['prices'] as $region_id => $price) {
                $finalRes['prices'][$region_id] = $this->processUpdate($product_id, $region_id, $price);
            }

        }

        return $finalRes;
    }


    /**
     * Do the update in the table
     * @param $product_id
     * @param $region_id
     * @param $price
     * @return array
     */
    private function processUpdate($product_id, $region_id, $price)
    {
        $product = Product::findOrFail($product_id);

        if (count($product->region()->where('region_id', $region_id)->get()) > 0) {
            $product->region()->where('region_id', $region_id)->update(
                [
                    'price_purchase' => $price['price_purchase'],
                    'price_selling' => $price['price_selling'],
                    'price_discount' => $price['price_discount']
                ]
            );
        } else {
            $product->region()->attach($region_id,
                [
                    'price_purchase' => $price['price_purchase'],
                    'price_selling' => $price['price_selling'],
                    'price_discount' => $price['price_discount']
                ]
            );
        }
        $res = [
                'price_purchase' => $price['price_purchase'],
                'price_selling' => $price['price_selling'],
                'price_discount' => $price['price_discount']
        ];

        return $res;
    }

    /**
     * Determine if request contains information about single product or multi products
     * @param array $data
     * @return bool
     */
    private function getProductInfoType(array $data)
    {
        if (isset($data[0]))
            return true;
        return false;
    }
}
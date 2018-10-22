<?php

namespace App\Quotes;

use App\Exceptions\QuoteException;

class QuoteGenerator
{
    /**
     * @param string   $designType
     * @param int      $productId
     * @param int      $colorsFront
     * @param int      $colorsBack
     * @param int      $colorsPocket
     * @param int      $colorsSleeve
     * @param int      $estimatedQuantityFrom
     * @param int|null $estimatedQuantityTo
     * @return Quote
     */
    public static function quickSimpleQuote($designType = 'screen', $productId, $colorsFront = 1, $colorsBack = 0, $colorsPocket = 0, $colorsSleeve = 0, $estimatedQuantityFrom = 24, $estimatedQuantityTo = null)
    {
        return static::quote($designType, [
            'pid' => $productId,
            'cf'  => $colorsFront,
            'cb'  => $colorsBack + $colorsPocket,
            'cl'  => $colorsSleeve,
            'eqf' => $estimatedQuantityFrom,
            'eqt' => $estimatedQuantityTo ?? $estimatedQuantityFrom,
        ]);
    }

    public static function quickManagerQuote()
    {

    }

    private static function quote($type, $data)
    {
        switch ($type) {
            case 'screen':
                if (isset($data['pid']) && $data['pid']) {
                    $productId = $data['pid'];
                    $product = product_repository()->find($productId);
                    if ($product == null) {
                        throw new QuoteException('Product must be valid');
                    }
                    $productName = $product->name;
                    $productPrice = $product->price;
                } elseif (isset($data['pn']) && isset($data['pp'])) {
                    $productName = $data['pn'];
                    $productPrice = $data['pp'];
                } else {
                    throw new QuoteException('Request must contain either product id or product price information');
                }

                $quote = new ScreenPrinterQuote();
                $quote->quote([
                    'product_name'            => $productName,
                    'product_cost'            => $productPrice,
                    'color_front'             => isset($data['cf']) ? $data['cf'] : 0,
                    'color_back'              => isset($data['cb']) ? $data['cb'] : 0,
                    'color_left'              => isset($data['cl']) ? $data['cl'] : 0,
                    'color_right'             => isset($data['cr']) ? $data['cr'] : 0,
                    'black_shirt'             => isset($data['bs']) ? $data['bs'] : 0,
                    'estimated_quantity_from' => $data['eqf'],
                    'estimated_quantity_to'   => $data['eqt'],
                    'design_hours'            => isset($data['dh']) ? $data['dh'] : null,
                    'markup'                  => isset($data['mu']) ? $data['mu'] : null,
                ]);
                if ($quote->isSuccess()) {
                    return $quote;
                } else {
                    throw new QuoteException(implode(', ', $quote->getErrors()));
                }
                break;
            case 'embroidery':
                if (isset($data['pid']) && $data['pid']) {
                    $productId = $data['pid'];
                    $product = product_repository()->find($productId);
                    if ($product == null) {
                        throw new QuoteException('Product must be valid');
                    }
                    $productName = $product->name;
                    $productPrice = $product->price;
                } elseif (isset($data['pn']) && isset($data['pp'])) {
                    $productName = $data['pn'];
                    $productPrice = $data['pp'];
                } else {
                    throw new QuoteException('Request must contain either product id or product price information');
                }

                $quote = new EmbroideryQuote();
                $quote->quote([
                    'product_name'            => $productName,
                    'product_cost'            => $productPrice,
                    'estimated_quantity_from' => $data['eqf'],
                    'estimated_quantity_to'   => $data['eqt'],
                    'design_hours'            => isset($data['dh']) ? $data['dh'] : null,
                    'markup'                  => isset($data['mu']) ? $data['mu'] : null,
                ]);

                if ($quote->isSuccess()) {
                    return $quote;
                } else {
                    throw new QuoteException(implode(', ', $quote->getErrors()));
                }
        }

        throw new QuoteException('Unknown Print Type');
    }
}
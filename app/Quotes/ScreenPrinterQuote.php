<?php

namespace App\Quotes;

use App\Quotes\Data\QuoteGroup;
use App\Quotes\Data\QuoteLine;

class ScreenPrinterQuote extends Quote
{
    public function getParameters()
    {
        return [
            'product_name'            => ['type' => 'string', 'default' => 'Garment Cost'],
            'product_cost'            => ['type' => 'money', 'default' => 5.00],
            'color_front'             => ['type' => 'integer', 'default' => 0],
            'color_back'              => ['type' => 'integer', 'default' => 0],
            'color_left'              => ['type' => 'integer', 'default' => 0],
            'color_right'             => ['type' => 'integer', 'default' => 0],
            'black_shirt'             => ['type' => 'select', 'values' => ['yes', 'no'], 'default' => 'no'],
            'estimated_quantity_from' => ['type' => 'integer', 'default' => 24],
            'estimated_quantity_to'   => ['type' => 'integer', 'default' => 48],
            'design_hours'            => ['type' => 'hour', 'default' => '2:00'],
            'rate'                    => ['type' => 'money', 'default' => 25],
            'markup'                  => ['type' => 'integer', 'default' => 65],
            'product_count'           => ['type' => 'integer', 'default' => 1],
        ];
    }

    /*
     * @return ScreenPrinterQuote
     */
    public function quote($data)
    {
        if ($data['estimated_quantity_from'] >= 144 && $data['estimated_quantity_from'] < $data['estimated_quantity_to']) {
            $data['estimated_quantity_to'] = $data['estimated_quantity_from'];
        }
        if (! isset($data['markup'])) {
            $data['markup'] = estimated_quantity_by_quantity('screen', $data['estimated_quantity_from'])->markup;
        }
        if (! $this->validateData($data)) {
            return $this;
        }
        $this->setData($data);

        $this->addGroup(new QuoteGroup('garment', 'Garment'));
        $this->addGroup(new QuoteGroup('printing', 'Printing'));
        $this->addGroup(new QuoteGroup('additional', 'Additional Costs'));
        $this->addGroup(new QuoteGroup('subtotal', 'Subtotal'));
        $this->addGroup(new QuoteGroup('markup', 'Markup'));
        $this->addGroup(new QuoteGroup('total', 'Total'));

        // Garment
        $this->getGroup('garment')->addLine(new QuoteLine('product', $data['product_name'], $data['product_cost'], $data['product_cost'], $data['product_cost'] * $data['estimated_quantity_from'], $data['product_cost'] * $data['estimated_quantity_to']));
        $this->getGroup('garment')->addLine(new QuoteLine('pocket', 'Additional - Pocket Cost', 0.21, 0.21, 0.21 * $data['estimated_quantity_from'], 0.21 * $data['estimated_quantity_to']));

        // Printing
        if ($data['color_front'] > 0) {
            $this->getGroup('printing')->addLine(new QuoteLine('front', 'Front of Shirt', $this->getColorCost($data['estimated_quantity_from'], $data['color_front']), $this->getColorCost($data['estimated_quantity_to'], $data['color_front']), $this->getColorCost($data['estimated_quantity_from'], $data['color_front']) * $data['estimated_quantity_from'], $this->getColorCost($data['estimated_quantity_to'], $data['color_front']) * $data['estimated_quantity_to']));
        }
        if ($data['color_back'] > 0) {
            $this->getGroup('printing')->addLine(new QuoteLine('back', 'Back of Shirt', $this->getColorCost($data['estimated_quantity_from'], $data['color_back']), $this->getColorCost($data['estimated_quantity_to'], $data['color_back']), $this->getColorCost($data['estimated_quantity_from'], $data['color_back']) * $data['estimated_quantity_from'], $this->getColorCost($data['estimated_quantity_to'], $data['color_back']) * $data['estimated_quantity_to']));
        }
        if ($data['color_left'] > 0) {
            $this->getGroup('printing')->addLine(new QuoteLine('back', 'Left Sleeve of Shirt', $this->getColorCost($data['estimated_quantity_from'], $data['color_left']), $this->getColorCost($data['estimated_quantity_to'], $data['color_left']), $this->getColorCost($data['estimated_quantity_from'], $data['color_left']) * $data['estimated_quantity_from'], $this->getColorCost($data['estimated_quantity_to'], $data['color_left']) * $data['estimated_quantity_to']));
        }
        if ($data['color_right'] > 0) {
            $this->getGroup('printing')->addLine(new QuoteLine('back', 'Right Sleeve of Shirt', $this->getColorCost($data['estimated_quantity_from'], $data['color_right']), $this->getColorCost($data['estimated_quantity_to'], $data['color_right']), $this->getColorCost($data['estimated_quantity_from'], $data['color_right']) * $data['estimated_quantity_from'], $this->getColorCost($data['estimated_quantity_to'], $data['color_right']) * $data['estimated_quantity_to']));
        }
        $this->getGroup('printing')->addLine(new QuoteLine('flash', 'Flash Cost', $this->getFlashCost($data['estimated_quantity_from']), $this->getFlashCost($data['estimated_quantity_to']), $this->getFlashCost($data['estimated_quantity_from']) * $data['estimated_quantity_from'], $this->getFlashCost($data['estimated_quantity_to']) * $data['estimated_quantity_to']));
        $screens = $data['color_front'] + $data['color_back'] + $data['color_left'] + $data['color_right'] + ($data['black_shirt'] == 'yes' ? 1 : 0) * (($data['color_front'] ? 1 : 0) + ($data['color_back'] ? 1 : 0) + ($data['color_left'] ? 1 : 0) + ($data['color_right'] ? 1 : 0));
        $this->getGroup('printing')->addLine(new QuoteLine('screens', $screens.' Screen'.($screens > 1 ? 's' : '').' at $10 per screen', null, null, $screens * 10, $screens * 10));

        // Additional
        $this->getGroup('additional')->addLine(new QuoteLine('shipping', 'Shipping', 0.45, 0.45, 0.45 * $data['estimated_quantity_from'], 0.45 * $data['estimated_quantity_to']));
        $this->getGroup('additional')->addLine(new QuoteLine('design_hours', 'Design Hours ('.ceil($data['design_hours'] / 60 / $data['product_count']).' hours at $'.$data['rate'].'/h)', null, null, $data['rate'] * ceil($data['design_hours'] / 60), $data['rate'] * ceil($data['design_hours'] / 60)));

        // Subtotal
        $this->getGroup('subtotal')->addLine(new QuoteLine('garment', 'Garment', null, null, $this->getGroup('garment')->getTotalFrom(), $this->getGroup('garment')->getTotalTo()));
        $this->getGroup('subtotal')->addLine(new QuoteLine('printing', 'Printing', null, null, $this->getGroup('printing')->getTotalFrom(), $this->getGroup('printing')->getTotalTo()));
        $this->getGroup('subtotal')->addLine(new QuoteLine('additional', 'Additional', null, null, $this->getGroup('additional')->getTotalFrom(), $this->getGroup('additional')->getTotalTo()));

        // Markup
        $this->getGroup('markup')->addLine(new QuoteLine('subtotal', 'Subtotal', null, null, $this->getGroup('subtotal')->getTotalFrom(), $this->getGroup('subtotal')->getTotalTo()));
        $this->getGroup('markup')->addLine(new QuoteLine('markup', 'Add '.$data['markup'].'% Markup', null, null, round($this->getGroup('markup')->getLine('subtotal')->getTotalFrom() * ($data['markup'] / 100), 2), round($this->getGroup('markup')->getLine('subtotal')->getTotalTo() * ($data['markup'] / 100), 2)));

        // Total
        $this->getGroup('total')->addLine(new QuoteLine('subtotal', 'Subtotal + '.$data['markup'].'% Markup', null, null, $this->getGroup('markup')->getTotalFrom(), $this->getGroup('markup')->getTotalTo()));
        $this->getGroup('total')->addLine(new QuoteLine('tag', 'Bag & Tag', 1, 1, $data['estimated_quantity_from'], $data['estimated_quantity_to']));
        $this->getGroup('total')->addLine(new QuoteLine('tax', '7% Sales Tax', null, null, round($this->getGroup('total')->getLine('subtotal')->getTotalFrom() * 0.07, 2), round($this->getGroup('total')->getLine('subtotal')->getTotalTo() * 0.07, 2)));

        $this->setSuccess(true);

        return $this;
    }

    public function getCostPerUnitFrom()
    {
        return ceil((($this->getGroup('subtotal')->getTotalFrom()) / $this->getData()['estimated_quantity_from']) * 100) / 100;
    }

    public function getCostPerUnitTo()
    {
        return ceil((($this->getGroup('subtotal')->getTotalTo()) / $this->getData()['estimated_quantity_to']) * 100) / 100;
    }

    public function getPricePerUnitFrom()
    {
        return ceil(($this->getGroup('total')->getTotalFrom() / $this->getData()['estimated_quantity_from']) * 100) / 100;
    }

    public function getPricePerUnitTo()
    {
        return ceil(($this->getGroup('total')->getTotalTo() / $this->getData()['estimated_quantity_to']) * 100) / 100;
    }

    public function getCostTotalFrom()
    {
        return $this->getGroup('subtotal')->getTotalFrom();
    }

    public function getCostTotalTo()
    {
        return $this->getGroup('subtotal')->getTotalTo();
    }

    public function getPriceTotalFrom()
    {
        return $this->getGroup('total')->getTotalFrom();
    }

    public function getPriceTotalTo()
    {
        return $this->getGroup('total')->getTotalTo();
    }
}

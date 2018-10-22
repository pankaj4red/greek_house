<?php

namespace App\Quotes;

use App\Quotes\Data\QuoteGroup;
use App\Quotes\Data\QuoteLine;

class EmbroideryQuote extends Quote
{
    public function getParameters()
    {
        return [
            'product_name'            => ['type' => 'string', 'default' => 'Garment Cost'],
            'product_cost'            => ['type' => 'money', 'default' => 5.00],
            'estimated_quantity_from' => ['type' => 'integer', 'default' => 24],
            'estimated_quantity_to'   => ['type' => 'integer', 'default' => 48],
            'design_hours'            => ['type' => 'hour', 'default' => '2:00'],
            'rate'                    => ['type' => 'money', 'default' => 25],
            'markup'                  => ['type' => 'integer', 'default' => 65],
            'product_count'           => ['type' => 'integer', 'default' => 1],
        ];
    }

    public function quote($data)
    {
        if ($data['estimated_quantity_from'] >= 144 && $data['estimated_quantity_from'] < $data['estimated_quantity_to']) {
            $data['estimated_quantity_to'] = $data['estimated_quantity_from'];
        }
        if (! $this->validateData($data)) {
            return $this;
        }
        $this->setData($data);

        $this->addGroup(new QuoteGroup('garment', 'Garment'));
        $this->addGroup(new QuoteGroup('embroidery', 'Embroidery'));
        $this->addGroup(new QuoteGroup('subtotal', 'Subtotal'));
        $this->addGroup(new QuoteGroup('markup', 'Markup'));
        $this->addGroup(new QuoteGroup('total', 'Total'));

        // Garment
        $this->getGroup('garment')->addLine(new QuoteLine('product', $data['product_name'], $data['product_cost'], $data['product_cost'], $data['product_cost'] * $data['estimated_quantity_from'], $data['product_cost'] * $data['estimated_quantity_to']));

        // Embroidery
        $this->getGroup('embroidery')->addLine(new QuoteLine('base', 'Base', 5, 5, 5 * $data['estimated_quantity_from'], 5 * $data['estimated_quantity_to']));
        $this->getGroup('embroidery')->addLine(new QuoteLine('embroidery', 'Embroidery', 1, 1, 1 * $data['estimated_quantity_from'], 1 * $data['estimated_quantity_to']));

        // Subtotal
        $this->getGroup('subtotal')->addLine(new QuoteLine('garment', 'Garment', null, null, $this->getGroup('garment')->getTotalFrom(), $this->getGroup('garment')->getTotalTo()));
        $this->getGroup('subtotal')->addLine(new QuoteLine('embroidery', 'Embroidery', null, null, $this->getGroup('embroidery')->getTotalFrom(), $this->getGroup('embroidery')->getTotalTo()));

        // Markup
        $this->getGroup('markup')->addLine(new QuoteLine('subtotal', 'Subtotal', null, null, $this->getGroup('subtotal')->getTotalFrom(), $this->getGroup('subtotal')->getTotalTo()));
        $this->getGroup('markup')->addLine(new QuoteLine('markup', 'Add '.$data['markup'].'% Markup', null, null, round($this->getGroup('markup')->getLine('subtotal')->getTotalFrom() * ($data['markup'] / 100), 2), round($this->getGroup('markup')->getLine('subtotal')->getTotalTo() * ($data['markup'] / 100), 2)));

        // Total
        $this->getGroup('total')->addLine(new QuoteLine('subtotal', 'Subtotal + '.$data['markup'].'% Markup', null, null, $this->getGroup('markup')->getTotalFrom(), $this->getGroup('markup')->getTotalTo()));
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

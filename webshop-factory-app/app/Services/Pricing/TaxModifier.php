<?php

namespace App\Services\Pricing;

class TaxModifier implements PriceModifier
{
    protected $taxRate;

    /**
     * Kreira novi TaxModifier s određenom stopom poreza.
     *
     * @param float $taxRate Stopa poreza, npr. 0.25 za 25%
     */
    public function __construct(float $taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * Primjenjuje porez na zadani međuzbroj.
     *
     * @param float $subtotal
     * @return float Iznos poreza
     */
    public function apply(float $subtotal): float
    {
        return $subtotal * $this->taxRate;
    }
}

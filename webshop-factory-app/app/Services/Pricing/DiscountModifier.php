<?php

namespace App\Services\Pricing;

class DiscountModifier implements PriceModifier
{
    protected $discountRate;
    protected $threshold;

    /**
     * Kreira novi DiscountModifier s određenom stopom popusta i pragom.
     *
     * @param float $discountRate Stopa popusta, npr. 0.10 za 10%
     * @param float $threshold Prag iznad kojeg se popust primjenjuje
     */
    public function __construct(float $discountRate, float $threshold)
    {
        $this->discountRate = $discountRate;
        $this->threshold = $threshold;
    }

    /**
     * Primjenjuje popust ako je međuzbroj veći od zadanog praga.
     *
     * @param float $subtotal
     * @return float Iznos popusta (ili 0 ako nije ispunjen prag)
     */
    public function apply(float $subtotal): float
    {
        if ($subtotal > $this->threshold) {
            return $subtotal * $this->discountRate;
        }
        return 0; // Nema popusta ako je ispod praga
    }
}

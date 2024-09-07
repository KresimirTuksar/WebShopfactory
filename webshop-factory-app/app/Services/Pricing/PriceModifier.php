<?php

namespace App\Services\Pricing;

interface PriceModifier
{
    /**
     * Primjenjuje modifikaciju na zadanu cijenu (subtotal).
     *
     * @param float $subtotal
     * @return float
     */
    public function apply(float $subtotal): float;
}

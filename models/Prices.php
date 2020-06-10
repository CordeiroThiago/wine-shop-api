<?php
class Prices {
    public float $totalItems = 0;
    public float $shipping = 0;
    public float $total = 0;
    
    public function __construct(array $wines, float $distance){
        $weight = 0;
        foreach($wines as $wine) {
            $this->totalItems += $wine["price"] * $wine["quantity"];
            $weight += $wine["weight"] * $wine["quantity"];
        }

        $this->shipping = ((int) $weight) * 5;

        if ($distance > 100) {
            $this->shipping = $this->shipping * $distance / 100;
        }

        $this->total = $this->totalItems + $this->shipping;
    }
}
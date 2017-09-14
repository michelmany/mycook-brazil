<?php

namespace App\Observables;

use App\Models\Moip\MoipSeller;

/**
 * Class MoipSellersObservable
 * @package App\Observables
 */
class MoipSellersObservable
{
    /**
     * @param MoipSeller $seller
     */
    public function creating(MoipSeller $seller)
    {
        //  implement business rules
    }
}
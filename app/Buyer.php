<?php

namespace App;

use App\Transaction;

class Buyer extends User
{

    /**
     * Get the list for the transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


}

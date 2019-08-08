<?php

namespace App;

class Buyer extends User
{
    public function transaction(){

        return $this->hasMany(Transaction::class);
    }


}

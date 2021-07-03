<?php

namespace App\Repositories;

use App\Http\Requests\SaveBaseMoneyRequest;
use Illuminate\Http\Request;

interface RepositoryInterface
{    

    public function loadBoxBase(array $request);

    public function paymentsRegister(array $request);

    public function boxBase();

    public function boxBaseForTypeMoney();

    public function emptyBox();    

    public function updateBaseMoney($value);
}
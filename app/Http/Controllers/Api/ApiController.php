<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseMoneyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentsController;
use App\Http\Requests\SaveBaseMoneyRequest;
use App\Repositories\CashRegisterRepositoryInterface;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**Declaracion de variables*/   
    private $baseMoneyController;
    private $paymentsController;

    /**
     *Constructor de la clase 
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function __construct(CashRegisterRepositoryInterface $repository)
    {
        $this->baseMoneyController = new BaseMoneyController($repository);   
        $this->paymentsController = new PaymentsController($repository);     
    }    
       
    /**
     * crear la base de dinero que va a tener la caja
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021 
     */
    public function loadBoxBase(Request $request){        
        $result = $this->baseMoneyController->loadBoxBase($request);
        return response()->json([
            'res' => $result
        ], 200);
    }

    /**
     * crear el pago y retorna la informacion de cambio mas optimo
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021 
     */
    public function paymentsRegister(Request $request){
        $result = $this->paymentsController->PaymentsRegister($request);
        return response()->json([
            'res' => $result
        ], 200);
    }

    /**
     * Metodo que retorna todos la base de cajero
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function boxBaseForTypeMoney(){
        $result = $this->baseMoneyController->boxBaseForTypeMoney();
        return response()->json([
            'res' => $result
        ], 200);
    }
    
    /**
     * Metodo que retorna todos la base de cajero
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function emptyBox(){
        $result = $this->baseMoneyController->emptyBox();
        return response()->json([
            'res' => $result
        ], 200);
    }
        
}

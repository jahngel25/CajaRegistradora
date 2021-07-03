<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Repositories\CashRegisterRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;

class PaymentsController extends Controller
{
    /** Declaracion de variables */
    private $repository;

    /**
     *Constructor de la clase 
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function __construct(CashRegisterRepositoryInterface $repository)
    {
        $this->repository = $repository;        
    }

    /**
     *crear el pago y retorna la informacion de cambio mas optimo 
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function PaymentsRegister(Request $request){
        try{
            
            /** Validacion saldo caja */
            $baseResult = $this->repository->boxBase()->sum('value');
            
            if($baseResult < $request->Input()["received_money"]){
                return "No se puede realizar el pago no hay dinero suficiente para devolucion";
            }
            
            /** se inserta el pago */
            $payments = [];
            $payments["received_money"] = $request->Input()["received_money"];            
            $payments["total_payments"] = $request->Input()["total_payments"];
            $payments["total_returned"] = $request->Input()["received_money"]-$request->Input()["total_payments"];
            $continueProcess = $this->optimalChange($payments["total_returned"]);

            if($continueProcess == false){
                return "No se puede realizar el pago no hay cantidad de monedas o billetes para la devolución";
            }

            $resultPayments = $this->repository->paymentsRegister($payments);            
            
            /** se inserta el dinero nuevo que ingresa a caja */
            foreach ($request->Input()["denomination_money"] as $key => $value) {
                $value["id_payments"] = $resultPayments->id;    
                $this->repository->loadBoxBase($value);
            }                        

            $this->UpdateBaseMoney($continueProcess);

            return $continueProcess;
            
        }catch(Exception $ex){
            Log::error("Error en el metodo PaymentsRegister de la clase PaymentsController = "+$ex);
            return "El proceso fallo";
        }
    }

    /**
     *retorna informacion de cambio mas optimo 
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function optimalChange($change){

        try{
            $arrayChange = [];
            $arrayData = $this->repository->boxBaseForTypeMoney();   
            /** se recorre data de monedas y biletes existentes */
            foreach ($arrayData as $key => $value) {
                $count = 0;
                for ($i=0; $i < $value["amount"]; $i++) { 
                    if($change >= $value["value"]){       
                        $count++;                       
                        $change = $change-$value["value"];                        
                    }else{
                        break;
                    }                              
                }  
                /** se agrega al array cuantos billetes o monedas de cierto valor se necesitan */          
                if($count > 0){
                    $arrayValor = [
                        "value" => $value["value"],
                        "description" => $value["description"],
                        "amount" => $count
                    ];
                    array_push($arrayChange, $arrayValor);
                }                    
            }
            if($change != 0){
                return false;
            }else{
                return $arrayChange;
            }                                        
        }catch(Exception $ex){
            Log::error('Error en el metodo boxBaseForTypeMoney de la clase BaseMoneyController = '+$ex);
            return "El proceso fallo";
        }
    }

    /**
     *deshabilita la moneda que se dio de cambio
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function UpdateBaseMoney($array){
        foreach ($array as $key => $value) {
            for ($i=0; $i < $value["amount"]; $i++) { 
                $this->repository->updateBaseMoney($value["value"]);
            }
        }
    }


}

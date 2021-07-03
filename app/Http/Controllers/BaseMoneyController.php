<?php

namespace App\Http\Controllers;

use App\Repositories\CashRegisterRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaseMoneyController extends Controller
{
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
     *Constructor de la clase 
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function loadBoxBase(Request $request){
        try{
            foreach ($request->input() as $value) {
                $this->repository->loadBoxBase($value);
            }    
            return "Proceso de cargar base caja realizado con exito";
        }
        catch(Exception $ex){
            Log::error('Error en el metodo loadBoxBase de la clase BaseMoneyController = '+$ex);
            return "El proceso fallo";
        }                
    }

    /**
     *Metodo que retorna todos la base de cajero
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function boxBaseForTypeMoney(){
        try{
            $baseResult = $this->repository->boxBase()->sum('value');
            $arrayData = $this->repository->boxBaseForTypeMoney();
            $result = [
                "totalMoney" => $baseResult,
                "amountTypeMoney" => $arrayData
            ];
            
            return $result;

        }catch(Exception $ex){
            Log::error('Error en el metodo boxBaseForTypeMoney de la clase BaseMoneyController = '+$ex);
            return "El proceso fallo";
        }
    }

    /**
     *Metodo que retorna todos la base de cajero
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function emptyBox(){
        try{
            $this->repository->emptyBox();
            return "Proceso de vaciar caja realizado con exito";
        }catch(Exception $ex){
            Log::error('Error en el metodo emptyBox de la clase BaseMoneyController = '+$ex);
            return "El proceso fallo";
        }
    }
}

<?php

namespace App\Repositories;

use App\Http\Requests\SaveBaseMoneyRequest;
use App\Models\BaseMoney;
use App\Models\Payments;
use Exception;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashRegisterRepository implements CashRegisterRepositoryInterface
{
    /** declaracion de variable */
    protected $model;
    protected $modelPayments;
    
    /**
     *Constructor de la clase 
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function __construct(BaseMoney $modelOne, Payments $modelTwo)
    {
        $this->model = $modelOne;
        $this->modelPayments = $modelTwo;
    }    
    
    /**
     *Carga registro a la tabla base_money tiene todo el dinero con el que cuenta la caja registradora
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function loadBoxBase(array $request)
    {
        return $this->model->create($request);                        
    }

    /**
     *Crea el pago con todas sus validaciones
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function paymentsRegister(array $request){
        return $this->modelPayments->create($request);
    }

    /**
     *Retorna todos los tipos de billetes y monedas existentes en la caja registradora
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function boxBase(){
        try{
            return $this->model
            ->join('denomination_money', 'denomination_money.id','=','base_money.id_denomination_money')
            ->join('type_money', 'type_money.id','=','denomination_money.id_type')
            ->where('base_money.action_type','=','1')            
            ->get();
        }catch(Exception $ex){
            Log::error("Error en el metodo boxBase de la clase CashRegisterRepository = "+$ex);
            return $ex;
        }
        
    }

    /**
     *Retorna la cantidad de monedas y billetes agrupados por tipp de donominacion
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function boxBaseForTypeMoney(){
        try{
            return $this->model
            ->select('value', 'description' ,DB::raw('count(*) as amount'))
            ->join('denomination_money', 'denomination_money.id','=','base_money.id_denomination_money')
            ->join('type_money', 'type_money.id','=','denomination_money.id_type')
            ->where('base_money.action_type','=','1')        
            ->groupBy('value','description')    
            ->orderBy('value', 'DESC')
            ->get()
            ->toArray();
        }catch(Exception $ex){
            Log::error("Error en el metodo boxBaseForTypeMoney de la clase CashRegisterRepository = "+$ex);
            return $ex;
        }        
    }    

    /**
     *Vacia la caja registradora
     * desarrollador: daniel angel
     * fecha creacion: 03/07/2021
     */
    public function emptyBox(){
        try{
            return $this->model->truncate();
        }catch(Exception $ex){
            Log::error("Error en el metodo emptyBox de la clase CashRegisterRepository = "+$ex);
            return $ex;
        }   
    }

    public function updateBaseMoney($value)
    {
        try{
            $data = $this->model
            ->select('base_money.id', 'base_money.action_type','base_money.id_denomination_money','base_money.id_payments','base_money.status')
            ->join('denomination_money', 'denomination_money.id','=','base_money.id_denomination_money')
            ->join('type_money', 'type_money.id','=','denomination_money.id_type')
            ->where('base_money.action_type','=','1')     
            ->where('denomination_money.value','=',$value)     
            ->limit(1)       
            ->first()
            ->toArray();

            $data["action_type"] = 2;            

            $result = $this->model->where('id', $data["id"])->update($data);

            return true;

        }catch(Exception $ex){
            dd($ex);
            Log::error("Error en el metodo updateBaseMoney de la clase CashRegisterRepository = "+$ex);
            return $ex;
        }        
        
        
        
    }
   
}
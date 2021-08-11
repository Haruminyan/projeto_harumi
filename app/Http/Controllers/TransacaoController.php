<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacao;
use App\Models\Usuario;
use GuzzleHttp\Client;

class TransacaoController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */

    public function transacao(Request $request)
    { 
        //tipo de usuário - 1 comum | 2 lojista        
        
        $usuariopagador = Usuario::find($request->payer);
        if ($usuariopagador == null)
        {
            return array("result" => false, "msg" => "Pagador não encontrado");   
        }

        $usuariorecebedor = Usuario::find($request->payee);
        if ($usuariorecebedor == null)
        {
            return array("result" => false, "msg" => "Recebedor não encontrado");
        }

        if ($usuariopagador == $usuariorecebedor)
        {
            return array("result" => false, "msg" => "Origem e destino iguais");
        }
                
        else 
        {        
            if ($usuariopagador->tipo == 2) 
            {
                return array("result" => false, "msg" => "Lojista não pode realizar pagamentos");
            }
            else 
            {           
                $client = new Client(); //GuzzleHttp\Client
                $url = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6"; // url da api da picpay
                $response = $client->request('GET', $url);
                
                if ($response->getStatusCode() == 200)
                {
                    $transacao        = new Transacao;
                    $transacao->payer = $request->payer;
                    $transacao->payee = $request->payee;
                    $transacao->value = $request->value;                
                    $transacao->save();       
                
                    if ($usuariopagador->saldo == 0) 
                    {
                        return array("result" => false, "msg" => "Saldo insuficiente");
                    }

                    if ($usuariopagador->saldo < $transacao->value) 
                    {
                        return array("result" => false, "msg" => "Saldo insuficiente");
                    }

                    $usuario = Usuario::find($request->payer);
                    $usuario->saldo = ($usuario->saldo - $transacao->value);
                    $usuario->save();

                    $usuario = Usuario::find($request->payee);
                    $usuario->saldo = ($usuario->saldo + $transacao->value);
                    $usuario->save();

                    return array("result" => true,"id" => $transacao->id, "msg" => "Transação realizada com sucesso");

                    $notification = new Client(); //GuzzleHttp\Client
                    $url = "http://o4d9z.mocklab.io/notify"; // url notificação api da picpay
                    $responsenotification = $client->request('GET', $url);

                    if ($responsenotification->getStatusCode() == 200) {
                        return array("result" => true,"id" => $transacao->id, "msg" => "E-mail/SMS enviada");
                    }
                    if ($responsenotification->getStatusCode() == 503) {
                        return array("result" => false,"id" => $transacao->id, "msg" => "E-mail/SMS não enviada");
                    }
                }
                if ($response->getStatusCode() == 503){
                    return array("result" => false,"msg" => "Não foi possível completar a transação");
                }               
                else 
                {
                    return array("result" => false,"msg" => "Transação não efetuada");
                }
            }
        }  
     }
}
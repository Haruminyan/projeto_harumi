<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;


class UsuarioController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */

    public function cadastra(Request $request){        
        $usuario = usuario::where('cpf_cnpj', $request->cpf_cnpj)->first();
        if ($usuario)
        {
            return array("result" => false, "msg" => "CPF|CNPJ já cadastrado");  
        }        
        else 
        {        
            $usuario = Usuario::where('email', $request->email)->first();
            if ($usuario)
            {
                return array("result" => false, "msg" => "E-mail já cadastrado");  
            }
            else 
            {           
                $usuario           = new Usuario;
                $usuario->nome     = $request->nome;
                $usuario->cpf_cnpj = $request->cpf_cnpj;
                $usuario->email    = $request->email;
                $usuario->tipo     = $request->tipo; //1 pessoa fisica | 2 pessoa jurídica 
                $usuario->senha    = $request->senha;
                $usuario->saldo    = $request->saldo;
                $usuario->save();       
                return array("result" => true,"id" => $usuario->id, "msg" => "Usuário cadastrado com sucesso");
            }
        }
     }
}
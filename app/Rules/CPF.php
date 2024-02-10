<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Cliente;

class CPF implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //somente números
        $cpf = preg_replace('/\D/','', $value);
        //verifica quantidade
        if(strlen($cpf) != 11){
            return false;
        }

        //dígito verificador
        $cpfValidacao = substr($cpf,0,9);
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);

        if($cpfValidacao == $cpf){
            $cliente = Cliente::where('CPF', $cpf)->get();
        //dd($cliente);
            if(empty($cliente[0])){
                return true;
            }else{
                return false;
            }
        } else{
            return false;
        }
    }
    //Método responsável por calcular um dígito verificador com base em uma sequência numérica
    public static function calcularDigitoVerificador($base){
        $tamanho = strlen($base);
        $multiplicador = $tamanho + 1;

        //soma
        $soma = 0;

        ///itera os números do cpf
        for($i = 0; $i < $tamanho; $i++){
            $soma += $base[$i] * $multiplicador;
            $multiplicador--;
        }

        //resto da divisão
        $resto = $soma % 11;

        //retorna o dígito verificador
        return $resto > 1 ? 11 - $resto : 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CPF inválido ou usuário já cadastrado.';
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use GuzzleHttp\Client; 

use App\Models\Client as User;
use App\Models\Operation;

class OperationController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'valor1' => 'required',
            'valor2' => 'required',
            'taxa' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/')->with('error', $validator->errors()->first());
        }

        $idClient = User::firstOrCreate(['name' => $request->input('name')]);

        $idClient = $idClient['id'];
        $oCurrency = $request->input('moedas1');
        $dCurrency = $request->input('moedas2');
        $oValue = $request->input('valor1');
        $cValue = $request->input('valor2');
        $cValue = $cValue - ($cValue/10);

        if ($oCurrency == $dCurrency) {
            return redirect('/')->with('error', 'A moeda de destino deve ser diferente da de origem!');
        }

        $rate = $request->input('taxa');
        $rate = explode(" ", $rate);
        if ($oCurrency != 'BRL') {
            $client = new Client;
            $conversor = $client->request('GET', 'https://economia.awesomeapi.com.br/last/'.$oCurrency.'-BRL');
            $conversor = json_decode($conversor->getBody(), true);

            $rate = $rate[1] * $conversor[$oCurrency.'BRL']['ask'];
        } else {
            $rate = $rate[1];
        }
        $rate = 'R$: '.$rate;

        $newOperation = new Operation;
        $newOperation->id_client = $idClient;
        $newOperation->origin_currency = $oCurrency;
        $newOperation->destiny_currency = $dCurrency;
        $newOperation->original_value = $oValue;
        $newOperation->converted_value = $cValue;
        $newOperation->rate = $rate;
        $newOperation->save();

        return redirect('/')->with('msg', 'Conversão feita com sucesso!');
    }

    public function getAll(Request $request) {
        $data = [];

        /* Pesquisando por nome */
        if ($request->input('byName')) {
            $clientId = User::select('id')->where('name', $request->input('byName'))->get();
            foreach ($clientId as $client) {
                $clientId = $client->id;
            }
            
            $operations = Operation::all()->where('id_client', $clientId);
        /* Pesquisando por data */
        } else if ($request->input('byDateInit') && $request->input('byDateEnd')) {
            $operations = Operation::whereBetween('created_at', [$request->input('byDateInit'), $request->input('byDateEnd')])->get();
        } else {
            $operations = Operation::all();
        }
        

        
        $data['operations'] = $operations;

        $totalOperations = 0;
        $totalRate = 0;

        foreach ($operations as $operation) {  
            /* convertendo todos os valores originais para mostrar o total em R$ */          
            if ($operation['origin_currency'] != 'BRL') {
                $currency = $operation['origin_currency'];   

                $client = new Client;
                $conversor = $client->request('GET', 'https://economia.awesomeapi.com.br/last/'.$currency.'-BRL');
                $conversor = json_decode($conversor->getBody(), true);
                
                $value = $operation['original_value'] * $conversor[$currency.'BRL']['ask'];
            } else {
                $value = $operation['original_value'];
            }
            $totalOperations += $value;

            /* formatando taxas ppara mostrar em notação br */
            $operation['rate'] = explode(" ", $operation['rate']);
            $operation['rate'] = $operation['rate'][1];            
            /* aproveitando para somar o total de taxas antes de formatar de volta */
            $totalRate += $operation['rate'];
            $operation['rate'] = 'R$: '.number_format($operation['rate'], 2, ",", ".");;
           
            /* formatando valores originais para notação br */
            $operation['original_value'] = number_format($operation['original_value'], 2, ",", ".");

            /* formatando os valores convertidos para notação br */
            $operation['converted_value'] = number_format($operation['converted_value'], 2, ",", ".");

            /* formatando a data */
            $date = date('d/m/Y', strtotime($operation['created_at']));
            $operation['date'] = $date;

            /* pegando nome do cliente pelo id_client */
            $operation['name'] = User::select('name')->where('id', $operation['id_client'])->get();
            $index = 0;
            foreach ($operation['name'] as $name) {
               $operation['name'][$index] = $name['name'];
               $index++;
            }
            $operation['name'] = $operation['name'][0];
        }
        
        $data['totalOperations'] ='R$: '.number_format($totalOperations, 2, ",", ".");
        /* $data['totalRate'] = 'R$: '.number_format($totalRate, 2, ",", "."); */
        $data['totalRate'] = 'R$: '.number_format($totalRate, 2, ",", ".");

        return view('table')->with($data);
    }
}

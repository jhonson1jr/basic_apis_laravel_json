<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulacaoRequest;
use Illuminate\Http\Request;

class APisController extends Controller
{
    public function getInstituicoes()
    {
        $decodificado = $this->getArquivoJsonDecodificado('instituicoes.json');
        return response()->json($decodificado, 200);        
    }
    
    public function getConvenios()
    {
        $decodificado = $this->getArquivoJsonDecodificado('convenios.json');
        return response()->json($decodificado, 200);        
    }

    public function Simulacao(SimulacaoRequest $request)
    {
        $json_convenios = $this->getArquivoJsonDecodificado('convenios.json');
        $json_instituicoes = $this->getArquivoJsonDecodificado('instituicoes.json');
        $json_taxas_instituicoes = $this->getArquivoJsonDecodificado('taxas_instituicoes.json');
        
        $valor_emprestimo = $request->valor_emprestimo;
        $instituicoes = (isset($request->instituicoes)) ? $request->instituicoes : 0;
        $convenios = (isset($request->convenios)) ? $request->convenios : 0;
        $parcelas = (isset($request->parcelas)) ? $request->parcelas : 0;

        // Variaveis auxiliares
        $resposta = array();
        $processamento = array();
        
        $c = 0;

        // Processando as instituicoes
        if ($instituicoes != 0) {            
            foreach ($json_instituicoes as $i) {
                foreach ($instituicoes as $instituicao) {
                    if ($instituicao == $i['chave']) {
                        array_push($processamento,[
                            "chave" => $i['chave'],
                            "valor" => $i['valor']
                        ]);
                    }
                }
            }
            $json_instituicoes = $processamento;
        }
        
        // Limpando variavel auxiliar
        $processamento = array();
        
        // Processando os convênios
        if ($convenios != 0) {            
            foreach ($json_convenios as $c) {
                foreach ($convenios as $convenio) {
                    if ($convenio == $c['chave']) {
                        array_push($processamento,[
                            "chave" => $c['chave'],
                            "valor" => $c['valor']
                        ]);
                    }
                }
            }
            $json_convenios = $processamento;
        }

        // Limpando variavel auxiliar
        $processamento = array();

        // Processando as taxas das instituicoes de acordo com os criterios passados
        foreach ($json_instituicoes as $i) {
            foreach ($json_taxas_instituicoes as $taxas) {
                if($taxas['instituicao'] == $i['chave'])
                {
                    array_push($processamento,[
                        "parcelas" => $taxas['parcelas'],
                        "taxaJuros" => $taxas['taxaJuros'],
                        "coeficiente" => $taxas['coeficiente'],
                        "instituicao" => $taxas['instituicao'],
                        "convenio" => $taxas['convenio']
                    ]);
                }
            }
        }
        $json_taxas_instituicoes = $processamento;

        // Limpando variavel auxiliar
        $processamento = array();

        // Processando os convenios de acordo com os criterios passados
        foreach ($json_convenios as $c) {
            foreach ($json_taxas_instituicoes as $taxas) {
                if($taxas['convenio'] == $c['chave'])
                {
                    array_push($processamento,[
                        "parcelas" => $taxas['parcelas'],
                        "taxaJuros" => $taxas['taxaJuros'],
                        "coeficiente" => $taxas['coeficiente'],
                        "instituicao" => $taxas['instituicao'],
                        "convenio" => $taxas['convenio']
                    ]);
                }
            }
        }
        
        $json_taxas_instituicoes = $processamento;

        // Limpando variavel auxiliar
        $processamento = array();

        // Processando as parcelas de acordo com os criterios passados
        if ($parcelas > 0){
            foreach ($json_taxas_instituicoes as $taxas) {
                if($taxas['parcelas'] == $parcelas)
                {
                    array_push($processamento,[
                        "parcelas" => $taxas['parcelas'],
                        "taxaJuros" => $taxas['taxaJuros'],
                        "coeficiente" => $taxas['coeficiente'],
                        "instituicao" => $taxas['instituicao'],
                        "convenio" => $taxas['convenio']
                    ]);
                }
            }
            $json_taxas_instituicoes = $processamento;
        }

        // Limpando variavel auxiliar
        $processamento = array();

        // Processamento final
        foreach ($json_instituicoes as $i) {
            // array_push($resposta, $i['chave']);
            foreach ($json_taxas_instituicoes as $taxas) {
                if($taxas['instituicao'] == $i['chave'])
                {
                    array_push($processamento,[
                        "taxa" => $taxas['taxaJuros'],
                        "parcelas" => $taxas['parcelas'],
                        "valor_parcela" => round(($valor_emprestimo * $taxas['coeficiente']), 2),
                        "convenio" => $taxas['convenio']
                    ]);
                }
            }
            $resposta[$i['chave']] = $processamento;
            $c++;
        }

        return response()->json($resposta, 200);     
    }

    private function getArquivoJsonDecodificado($arquivo){
        // arquivos jsons disponivels em /jsons
        $original = base_path() . "/jsons/". $arquivo;
        return json_decode(file_get_contents($original), true); 
    }
}

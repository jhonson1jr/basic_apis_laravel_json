<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APisController extends Controller
{
    public function getInstituicoes(){
        // arquivos jsons disponivels em /jsons
        $arquivo_instituicoes = base_path() . "/jsons/instituicoes.json";
        $decodificado = json_decode(file_get_contents($arquivo_instituicoes), true); 
        return response()->json($decodificado);        
    }
    
    public function getConvenios(){
        // arquivos jsons disponivels em /jsons
        $arquivo_instituicoes = base_path() . "/jsons/instituicoes.json";
        $decodificado = json_decode(file_get_contents($arquivo_instituicoes), true); 
        return response()->json($decodificado);        
    }
}

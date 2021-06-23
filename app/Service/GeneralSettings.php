<?php

namespace App\Service;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $em_analise;
    public string $orcamento;
    public string $autorizacao;
    public string $diagramacao;
    public string $impressao;
    public string $acabamento;
    public string $finalizado;
    public string $devolucao;
        
    public static function group(): string
    {
        return 'general';
    }
}
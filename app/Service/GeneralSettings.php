<?php

namespace App\Service;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $em_analise;
    public string $orcamento;
    public string $autorizacao;
    public string $autorizado;
    public string $diagramacao;
    public string $impressao;
    public string $finalizado;
    public string $devolucao;
    public string $chat;
        
    public static function group(): string
    {
        return 'general';
    }
}
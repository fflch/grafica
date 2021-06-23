<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.em_analise', 'Prezado(a) %usuario,<br>

        Você tem um novo pedido no sistema para ser analisado.<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
        $this->migrator->add('general.orcamento', 'Prezado(a) %usuario,<br>

        Você tem um pedido esperando por orçamento.<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
        $this->migrator->add('general.autorizacao', 'Prezado(a) %usuario,<br>

        Você tem um novo pedido no sistema para ser autorizado pelo responsável do Centro de Despesa.<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
        $this->migrator->add('general.diagramacao', 'Prezado(a) %usuario,<br>

        Você tem um novo pedido no sistema para ser diagramado.<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
        $this->migrator->add('general.impressao', 'Prezado(a) %usuario,<br>

        Você tem um novo pedido no sistema para ser impresso.<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
        $this->migrator->add('general.acabamento', 'Prezado(a) %usuario,<br>

        Seu pedido está em fase de acabamento.<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
        $this->migrator->add('general.finalizado', 'Prezado(a) %usuario,<br>

        Seu pedido foi finalizado.<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
        $this->migrator->add('general.devolucao', 'Prezado(a) %usuario,<br>

        Seu pedido foi devolvido para status "Em Elaboração".<br>
        
        Mensagem:<br>
        
        %mensagem
        
        <h4><b>Sistema - Gráfica - FFLCH</b></h4>');
    }
}

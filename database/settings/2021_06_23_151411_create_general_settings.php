<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.em_analise', file_get_contents(__DIR__ . "/defaults/em_analise.txt"));
        $this->migrator->add('general.orcamento', file_get_contents(__DIR__ . "/defaults/orcamento.txt"));
        $this->migrator->add('general.autorizacao', file_get_contents(__DIR__ . "/defaults/autorizacao.txt"));
        $this->migrator->add('general.autorizado', file_get_contents(__DIR__ . "/defaults/autorizado.txt"));
        $this->migrator->add('general.diagramacao', file_get_contents(__DIR__ . "/defaults/diagramacao.txt"));
        $this->migrator->add('general.impressao', file_get_contents(__DIR__ . "/defaults/impressao.txt"));
        $this->migrator->add('general.finalizado', file_get_contents(__DIR__ . "/defaults/finalizado.txt"));
        $this->migrator->add('general.devolucao', file_get_contents(__DIR__ . "/defaults/devolucao.txt"));
        $this->migrator->add('general.chat', file_get_contents(__DIR__ . "/defaults/chat.txt"));
    }
}

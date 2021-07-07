<?php

namespace App\Utils;

use Uspdev\Replicado\DB as DBreplicado;
use Uspdev\Replicado\Uteis;

class ReplicadoUtils {

    public static function listarDocentesServidores(){
        $unidade = getenv('REPLICADO_CODUNDCLG');
        $query  = "SELECT DISTINCT LOCALIZAPESSOA.codpes, LOCALIZAPESSOA.nompes FROM LOCALIZAPESSOA
                    WHERE (LOCALIZAPESSOA.tipvinext LIKE '%Servidor%'
                        OR LOCALIZAPESSOA.tipvinext LIKE '%Docente%'
                        AND LOCALIZAPESSOA.codundclg = {$unidade}
                        AND LOCALIZAPESSOA.sitatl = 'A')
                    ORDER BY LOCALIZAPESSOA.nompes";
        return DBreplicado::fetchAll($query);
    }

} 
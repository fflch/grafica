<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\ModelStatus\Events\StatusUpdated;

class ListenerStatusUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StatusUpdated  $event
     * @return void
     */
    public function handle(StatusUpdated $event)
    {
        if($event->newStatus == 'Em Análise'){

        }
        elseif($event->newStatus == 'Orçamento'){

        }
        elseif($event->newStatus == 'Autorização'){
            
        }
        elseif($event->newStatus == 'Editora'){
            
        }
        elseif($event->newStatus == 'Gráfica'){
            
        }
        elseif($event->newStatus == 'Finalizado'){
            
        }
        elseif($event->newStatus == 'Em Elaboração' and $event->oldStatus !=  null){
                
        }
    }
}

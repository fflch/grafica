<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedido;

class Orcamento extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Orcamento;
use App\Models\File;

class Pedido extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public static function tipoOptions(){
        return [
            'Diagramação',
            'Impressão',
            'Diagramação + Impressão',
        ];
    }

    public function setUserIdAttribute($value)
    {
        if(auth()->check()) {
            if($this->user_id != null){
                $this->attributes['user_id'] = $this->user->id;
            }
            else if(auth()->user()){
                    $this->attributes['user_id'] = auth()->user()->id;
            }
        } else {
            # para rodar o seeder
            $this->attributes['user_id'] = $value;
        }
        
    }
}

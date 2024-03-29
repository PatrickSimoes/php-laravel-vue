<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function produtos() {
        //return $this->belongsToMany(Produto::class, 'pedidos_produtos');

        return $this->belongsToMany(item::class, 'pedidos_produtos', 'pedido_id', 'produto_id')->withPivot('id', 'created_at', 'updated_at');
        /*
            1 - Modelo do relacionamento NxN em relação o Modelo que estamos implementando
            2 - É a tabela auxiliar que armazena os registros de relacionamento
            3 - Representa o nome da FK da tabela mapeada pelo modelo na tabela de relacionamento
            4 - Representa o nome da FK da tabela mapelada pelo model utilizado no relacionamento que estamos implementando
        */
    }
}
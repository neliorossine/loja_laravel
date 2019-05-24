<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itens extends Model
{
    protected $fillable = ['id_pedido','id_produto','quantidade'];
}

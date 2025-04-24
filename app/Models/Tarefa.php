<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'prioridade',
        'data_vencimento',
        'user_id'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tarefa_tag');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
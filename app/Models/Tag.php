<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['nome'];
    
    public function tarefas()
    {
        return $this->belongsToMany(Tarefa::class, 'tarefa_tag'); // certo!
    }
}

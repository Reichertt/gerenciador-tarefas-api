<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::all());
    }

    public function store(Request $request)
    {
        // Lista de chaves obrigatórias
        $camposObrigatorios = ['nome'];

        // Verifica se todos os campos foram enviados
        foreach ($camposObrigatorios as $campo) {
            if (!$request->has($campo)) {
                return response()->json([
                    'message' => "O campo '{$campo}' é obrigatório no corpo da requisição."
                ], 422);
            }
        }

        $request->validate([
            'nome' => 'required|string|unique:tags,nome',
        ], [
            'nome.unique' => 'Já existe uma tag com esse nome.',
            'nome.required' => 'O campo nome é obrigatório.',
        ]);

        $tag = Tag::create([
            'nome' => $request->nome,
        ]);

        return response()->json($tag, 201);
    }

    public function show($id)
    {
        $tag = Tag::find($id);
    
        if (!$tag) {
            return response()->json([
                'message' => 'Essa tag não existe mais no banco de dados.'
            ], 404);
        }
    
        return response()->json($tag);
    }

    public function update(Request $request, $id)
    {
        // Verifica campos obrigatórios
        if (!$request->has('nome')) {
            return response()->json([
                'message' => "O campo 'nome' é obrigatório no corpo da requisição."
            ], 422);
        }
    
        // Busca a tag
        $tag = Tag::find($id);
    
        if (!$tag) {
            return response()->json([
                'message' => 'Essa tag não existe mais no banco de dados.'
            ], 404);
        }
    
        // Validação
        $request->validate([
            'nome' => 'required|string|unique:tags,nome',
        ], [
            'nome.unique' => 'Já existe uma tag com esse nome.',
            'nome.required' => 'O campo nome é obrigatório.',
        ]);
    
        // Atualiza
        $tag->update(['nome' => $request->nome]);
    
        return response()->json($tag);
    }    

    public function destroy($id)
    {
        Tag::destroy($id);

        return response()->json(['message' => 'Tag excluída com sucesso']);
    }
}

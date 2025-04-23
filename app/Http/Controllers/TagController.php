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
        $request->validate([
            'nome' => 'required|string|unique:tags,nome',
        ]);

        $tag = Tag::create([
            'nome' => $request->nome,
        ]);

        return response()->json($tag, 201);
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json($tag);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|unique:tags,nome,' . $id,
        ]);

        $tag->update(['nome' => $request->nome]);

        return response()->json($tag);
    }

    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json(['message' => 'Tag excluída com sucesso']);
    }
}

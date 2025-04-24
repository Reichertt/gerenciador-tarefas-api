<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\TarefaAtribuida;

class TarefaController extends Controller
{
    // Listar tarefas com filtros e ordenações
    public function index(Request $request)
    {
        $tarefas = Tarefa::with('tags')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->prioridade, fn($q) => $q->where('prioridade', $request->prioridade))
            ->when($request->data_vencimento, fn($q) => $q->whereDate('data_vencimento', $request->data_vencimento))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->tag, fn($q) =>
                $q->whereHas('tags', fn($q2) => $q2->where('nome', $request->tag))
            )
            ->orderBy($request->orderby ?? 'data_vencimento', $request->order ?? 'asc')
            ->get();

        return response()->json($tarefas);
    }

    // Criar tarefa
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|in:pendente,em andamento,concluído',
            'prioridade' => 'required|in:baixa,média,alta',
            'data_vencimento' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'tags' => 'array'
        ]);
    
        $tarefa = Tarefa::create($request->only([
            'titulo', 'descricao', 'status', 'prioridade', 'data_vencimento', 'user_id'
        ]));
    
        if ($request->has('tags')) {
            $tagsIds = $this->getOrCreateTags($request->tags);
            $tarefa->tags()->sync($tagsIds);
        }
    
        // 🔔 Envia notificação ao usuário responsável
        $user = User::find($request->user_id);
        if ($user) {
            $user->notify(new TarefaAtribuida($tarefa));
        }
    
        return response()->json($tarefa, 201);
    }

    // Mostrar uma tarefa
    public function show($id)
    {
        $tarefa = Tarefa::with('tags')->findOrFail($id);
        return response()->json($tarefa);
    }

    // Atualizar tarefa
    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);

        if (Auth::id() !== $tarefa->user_id && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descricao' => 'sometimes|string',
            'status' => 'sometimes|in:pendente,em andamento,concluído',
            'prioridade' => 'sometimes|in:baixa,média,alta',
            'data_vencimento' => 'sometimes|date',
            'tags' => 'array'
        ]);

        $tarefa->update($request->only([
            'titulo', 'descricao', 'status', 'prioridade', 'data_vencimento'
        ]));

        if ($request->has('tags')) {
            $tagsIds = $this->getOrCreateTags($request->tags);
            $tarefa->tags()->sync($tagsIds);
        }

        return response()->json($tarefa);
    }

    // Deletar tarefa
    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);

        if (Auth::id() !== $tarefa->user_id && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $tarefa->delete();
        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }

    // Função para pegar ou criar tags
    private function getOrCreateTags(array $tags)
    {
        return collect($tags)->map(function ($nome) {
            return Tag::firstOrCreate(['nome' => $nome])->id;
        });
    }

    public function filtrar(Request $request)
    {
        // Lista de chaves obrigatórias
        $camposObrigatorios = ['status', 'prioridade', 'user_id', 'tags', 'orderby', 'order'];
    
        // Verifica se todos os campos foram enviados
        foreach ($camposObrigatorios as $campo) {
            if (!$request->has($campo)) {
                return response()->json([
                    'message' => "O campo '{$campo}' é obrigatório no corpo da requisição."
                ], 422);
            }
        }
    
        // Consulta com filtros aplicáveis (se não forem vazios)
        $tarefas = Tarefa::with('tags')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->prioridade, fn($q) => $q->where('prioridade', $request->prioridade))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->tags && is_array($request->tags) && !empty(array_filter($request->tags)), function ($q) use ($request) {
                return $q->whereHas('tags', fn($q2) => $q2->whereIn('nome', $request->tags));
            })
            ->orderBy($request->orderby ?: 'data_vencimento', $request->order ?: 'asc')
            ->get();
    
        return response()->json($tarefas);
    }        
}

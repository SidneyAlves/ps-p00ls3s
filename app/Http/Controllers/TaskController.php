<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request) {
        try {
            Task::create([
                'dimension_id' => $request->dimension_id,
                'name' => $request->name,
                'active' => true
            ]);

            return ['success' => 'Tarefa criada com sucesso'];
        } catch (\Exception $e) {
            return ['error' => 'Tarefa nao pode ser salva'];
        }
    }

    public function show() {
        try {
            $tasks = DB::table('tasks')
            ->join('dimensions', 'tasks.dimension_id', '=', 'dimensions.id')
            ->select('tasks.*','dimensions.name as dimension_name')
            ->get();

            return $tasks;
        } catch (\Exception $e) {
            return ['error' => 'Erro ao buscar tarefas'];
        }
    }

    public function update(Request $request, $id) {
        try {
            $task = Task::findOrFail($id);

            $task->update([
                'dimension_id' => $request->dimension_id,
                'name' => $request->name,
                'active' => $request->active
            ]);

            return ['success' => 'Tarefa atualizada com sucesso'];
        } catch (\Exception $e) {
            return ['error' => 'Tarefa nao pode ser atualizada'];
        }
    }

    public function destroy($id) {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return ['success' => 'Tarefa excluida com sucesso'];
        } catch (\Exception $e) {
            return ['error' => 'Erro ao excluir tarefa'];
        }
    }
}

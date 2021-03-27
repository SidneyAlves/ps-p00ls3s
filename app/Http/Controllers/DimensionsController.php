<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dimension;

class DimensionsController extends Controller
{
    public function store(Request $request) {
        try {
            Dimension::create([
                'name' => $request->dimension
            ]);

            return ['success' => 'Dimensao criada com sucesso'];
        } catch (\Exception $e) {
            return ['error' => 'Dimensao nao pode ser salva'];
        }
    }

    public function show() {
        try {
            $dimensions = Dimension::all();

            return $dimensions;
        } catch (\Exception $e) {
            return ['error' => 'Erro ao buscar dimensoes'];
        }
    }

    public function update(Request $request, $id) {
        try {
            $dimension = Dimension::findOrFail($id);

            $dimension->update([
                'name' => $request->name
            ]);

            return ['success' => 'Dimensao atualizada com sucesso'];
        } catch (\Exception $e) {
            return ['error' => 'Dimensao nao pode ser atualizada'];
        }
    }

    public function destroy($id) {
        try {
            $dimension = Dimension::findOrFail($id);
            $dimension->delete();

            return ['success' => 'Dimensao excluida com sucesso'];
        } catch (\Exception $e) {
            return ['error' => 'Voce precisa excluir a pergunta vinculada a dimensao antes de exclui-la'];
        }
    }
}

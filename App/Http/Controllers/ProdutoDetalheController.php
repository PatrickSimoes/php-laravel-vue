<?php

namespace App\Http\Controllers;

use App\Models\itemDetalhe;
use App\Models\ProdutoDetalhe;
use App\Models\Unidade;
use Illuminate\Http\Request;

class ProdutoDetalheController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('app.produto_detalhe.create', ['unidades' => $unidades]);
    }

    public function store(Request $request)
    {
        ProdutoDetalhe::create($request->all());
        echo 'Cadastro realizado com sucesso';
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $produtoDetalhe = ItemDetalhe::with(['item'])->find($id);
        $unidades = Unidade::all();
        return view('app.produto_detalhe.edit', ['produto_detalhe' => $produtoDetalhe, 'unidades' => $unidades]);
    }

    public function update(Request $request, ProdutoDetalhe $produtoDetalhe)
    {
        $produtoDetalhe->update($request->all());
        echo 'Atualização foi realizada com sucesso';
    }

    public function destroy($id)
    {
        //
    }
}

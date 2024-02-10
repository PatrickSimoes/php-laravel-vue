<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index() {
        return view('app.fornecedor.index');
    }

    public function listar(Request $request) {
        $fornecedores = Fornecedor::with(['produtos'])
        ->where('nome', 'like', '%'.$request->input('nome'). '%')
        ->where('site', 'like', '%'.$request->input('site'). '%')
        ->where('uf', 'like', '%'.$request->input('uf'). '%')
        ->where('email', 'like', '%'.$request->input('email'). '%')
        ->paginate(5);

        return view('app.fornecedor.listar', ['fornecedores' => $fornecedores, 'request' => $request->all()]);
    }

    public function adicionar(Request $request) {

        $msg = '';

        if($request->input('_token') != '' && $request->input('id') == '') {
            $regras = [
                'nome' => 'required|min:3|max:40',
                'site' => 'required',
                'uf' => 'required|min:2|max:2',
                'email' => 'email'
            ];

            $feedback = [
                'required' => 'O campo precisa ser preenchido',
                'email' => 'O campo precisa ser um E-mail',
                'nome.min' => 'o campo precisa ter no minimo 3 caracteres',
                'nome.max' => 'o campo precisa ter no minimo 40 caracteres',
                'uf.min' => 'O campo precisa ter no minimo 2 caracteres',
                'uf.max' => 'O campo precisa ter no máximo 2 caracteres',
            ];

            $request->validate($regras, $feedback);

            $fornecedor = new Fornecedor();

            $fornecedor->create($request->all());

            $msg = 'Cadastro realizado com sucesso';
        }

        if($request->input('_token') != '' && $request->input('id') != '') {
            $fornecedor = Fornecedor::find($request->input('id'));
            
            $update = $fornecedor->update($request->all());

            if($update) {
                $msg = 'Atualização realizada com Sucesso!';
            }else {
                $msg = 'Erro! não foi possível editar o registro.';
            }

            return redirect()->route('app.fornecedor.editar', ['id' => $request->input('id'), 'msg' => $msg]);
        }
        
        return view('app.fornecedor.adicionar', ['msg' => $msg]);
    }

    public function editar($id, $msg = '') {
        $fornecedor = Fornecedor::find($id);

        return view('app.fornecedor.adicionar', ['fornecedor' => $fornecedor, 'msg' => $msg]);
    }

    public function excluir($id) {
        $msg = '';

        $fornecedor = Fornecedor::destroy($id);

        if($fornecedor) {
            $msg = 'Registro Excluido com sucesso';
        }else {
            $msg = 'Erro! não foi possível excluir esse registro';
        }

        return redirect()->route('app.fornecedor', ['fornecedor' => $fornecedor, 'msg' => $msg]);
    }
}

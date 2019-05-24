<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Itens;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $produtos = Produto::latest()->paginate(5);
        return view('produto.index',compact('produtos'))->with('i', (request()->input('page', 1) - 1) * 5);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'SKU' => 'required',
            'nome' => 'required',
            'preco' => 'required'
        ]);

        $produto = $request->all();
        $produto['preco'] = number_format(str_replace(",",".",str_replace(".","",$produto['preco'])), 2, '.', '');

        Produto::create($produto);
        return redirect()->route('produto.index')->with('success','Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        return view('produto.show',compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        return view('produto.edit',compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'SKU' => 'required',
            'nome' => 'required',
            'preco' => 'required'
        ]);

        $prod = $request->all();
        $prod['preco'] = number_format(str_replace(",",".",str_replace(".","",$prod['preco'])), 2, '.', '');

        $produto->update($prod);
        return redirect()->route('produto.index')->with('success','Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto, Itens $itens)
    {   
        $itens->where('id_produto', '=', $produto->id)->delete();
        $produto->delete();
        return redirect()->route('produto.index')->with('success','Produto deletado com sucesso.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Produto;
use App\Itens;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos  = Pedido::select(\DB::raw(" * , 
                        (SELECT GROUP_CONCAT(CONCAT(quantidade,' ', nome) SEPARATOR ', ') FROM itens 
                        INNER JOIN produtos ON itens.id_produto = produtos.id 
                        WHERE pedidos.id = itens.id_pedido) AS produtos"))
                    ->paginate(5);

        return view('pedido.index',compact('pedidos'))
                ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Produto $produtos, Pedido $pedidos)
    {   
        $venda = array();
        $produtos = Produto::orderBy('nome', 'asc')->get();

        return view('pedido.create', compact('produtos', 'pedidos', 'venda'));
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
            'venda' => 'required',
        ]); 

        $itens = $request->all();

        $pedido = Pedido::create([
                 'total' => $itens['total'],
                 'data' => date('Y-m-d')
        ]);

        foreach ($itens['venda'] as $item) {
            Itens::create([
                    'id_pedido'  => $pedido->id,
                    'id_produto' => $item['produto'],
                    'quantidade' => $item['qtde']
            ]);
        }

        return redirect()->route('pedido.index')->with('success','Pedido criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {   
        $itens = Itens::select('id_produto', 'nome', 'preco', 'quantidade')
         ->join('produtos', 'produtos.id', '=', 'itens.id_produto')
         ->where('id_pedido' , '=' , $pedido->id)
         ->get();
         
        return view('pedido.show',compact('pedido', 'itens'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produtos, Pedido $pedido, Itens $itens)
    {
         $venda = array();
         $produtos = Produto::orderBy('nome', 'asc')->get();
         $itens = Itens::select('id_produto', 'nome', 'preco', 'quantidade')
         ->join('produtos', 'produtos.id', '=', 'itens.id_produto')
         ->where('id_pedido' , '=' , $pedido->id)
         ->get();

        return view('pedido.edit', compact('produtos', 'pedido', 'venda', 'itens'))->with('i');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido, Itens $itens)
    {
        $request->validate([
            'venda' => 'required',
        ]); 

        $new_itens = $request->all();

        $pedido->update([
                'total' => $new_itens['total'],
                'data' => date('Y-m-d')
        ]);

        $itens->where('id_pedido', '=', $pedido->id)->delete();
        foreach ($new_itens['venda'] as $item) {
            if(isset($item['produto'])){
                Itens::create([
                        'id_pedido'  => $pedido->id,
                        'id_produto' => $item['produto'],
                        'quantidade' => $item['qtde']
                ]);
            }
        }
        return redirect()->route('pedido.index')->with('success','Pedido alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido, Itens $itens)
    {   
        $itens->where('id_pedido', '=', $pedido->id)->delete();
        $pedido->delete();
        return redirect()->route('pedido.index')->with('success','Pedido removido com sucesso');
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ProductClientPrice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clientProducts = []; // Define an empty array for $products
        $user = Auth::user();

        $products = Product::orderBy('id')->get();
        
        if ($request->ajax()) {
            $clientProducts = ProductClientPrice::where('user_id',$user->id)->with('product','client')->get();
            return DataTables::of($clientProducts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = $btn . '<a class="deleteProduct delClass" data-id="' . $row->id . '"><i class="mdi mdi-delete-alert text-danger"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('product-client.index', compact('user','clientProducts','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $productclient = new ProductClientPrice;
        $productclient->product_id = $request->product_id;
        $productclient->user_id = $user->id;
        $productclient->price = $request->price;
        $productclient->save();
        return response()->json(["message" => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::whereId($id)->first();

        $clientProducts = ProductClientPrice::where('user_id',$id)->with('product')->get();

        if (request()->ajax()) {
            return DataTables::of($clientProducts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<a class="deleteProduct delClass" data-id="' . $row->id . '"><i class="mdi mdi-delete-alert text-danger"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('product-client.show', compact('client', 'clientProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductClientPrice::destroy($id);
        return response()->json([
            "message" => 'success'
        ]);
    }
}

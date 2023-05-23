<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ProductClientPrice;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all();
        
        $clients = []; // Define an empty array for $clients

        if ($request->ajax()) {
            $clients = User::where('role_id',2)->orderBy('id')->get();
            return DataTables::of($clients)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = $btn . '<a class="addClientPrice delClass"  data-toggle="tooltip" data-original-title="Add Price" data-id="' . $row->id . '"><i class="fa fa-plus text-success"></i></a>  ';

                    $btn = $btn . '<a class="deleteClient delClass" data-id="' . $row->id . '"><i class="mdi mdi-delete-alert text-danger"></i></a>';

                    return $btn;
                })
                ->editColumn('name', function ($row) {
                    return  '<a href="' . route('product-client.show', $row->id) . '" class="dropdown-item text-decoration-none text-primary">'. $row->name.'</a>';
                })
                ->rawColumns(['name','action'])
                ->make(true);
        }

        return view('client.index', compact('clients', 'products'));
    }

    // Handle the form submission to set up special prices
    public function setPrices(Request $request)
    {
        $product_id = $request->product_id;
        $user_id = $request->client_id;
    
        // Check if product_id already exists for the user_id
        $existingPrice = ProductClientPrice::where('product_id', $product_id)
                                            ->where('user_id', $user_id)
                                            ->exists();
    
        if ($existingPrice) {
            // Product price already exists for the user
            return response()->json(['message' => 'Already exists']);
        }
    
        // Create and save the new product-client price
        $productClient = new ProductClientPrice;
        $productClient->product_id = $product_id;
        $productClient->user_id = $user_id;
        $productClient->price = $request->price;
        $productClient->save();
    
        return response()->json(["message" => 'success']);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        // Delete records from ProductClientPrice table
        ProductClientPrice::where("user_id",$id)->delete();
        User::destroy($id);
        return response()->json([
            "message" => 'success'
        ]);
    }
}

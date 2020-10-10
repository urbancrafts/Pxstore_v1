<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{

    public function get_all_products_and_sub_category()
    {
        $product_category = ProductCategory::all()->toArray();
        $sub_category = SubCategory::all()->toArray();
        
        return response()->json(['category' => $product_category, 'sub_category' => $sub_category]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'catergory' => ['required', 'string']
        ]]);

        return ProductCategory::create([
            'catergory' => $request->input('catergory')
        ]);
    }


    public function update(Request $request, $id)
    {
        //
    }



    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

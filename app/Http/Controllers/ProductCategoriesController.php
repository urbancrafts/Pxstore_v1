<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{

    public function category()
    {
        $product_category = ProductCategory::all()->toArray();
        $sub_category = SubCategory::all()->toArray();
        
        return response()->json(['category' => $product_category, 'sub_category' => $sub_category]);
    }


    protected static $value;
    public function new_product_category(Request $request)
    {
        $this->validate($request,[
            'catergory' => ['required', 'string']
        ]);

        $category = ProductCategory::create([
            'catergory' => $request->input('catergory')
        ]);
        return self::$value = $category->id;
    }

    public function new_product_sub_category(Request $request)
    {
        $this->validate($request, [
            'cat_id' => ['required', 'string'],
            'su_category' => ['required', 'string']
        ]);

        return SubCategory::create([
            'cat_id' => self::$value,
            'su_category' => $request->input('catergory')
        ]);
    }


    public function Single_category($id)
    {
        $product_category = ProductCategory::findOrFail($id);
        $sub_category = SubCategory::findOrFail($id);

        return response()->json(['category' => $product_category, 'sub_category' => $sub_category]);
    }

}

<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;

class ProductController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
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
    public  $img_dir1, $img_dir2, $img_dir3, $img_dir4;
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|nullable',
            'detail' => 'required|nullable',
            'price' => 'required|nullable',
            'prodType' => 'required|nullable', 
            // 'prodClass' => 'required|nullable', 
            'salesPrice' => 'required|nullable',
            'stock' => 'required|nullable',
            'cat' => 'required|nullable',
            'brandName' => 'required|nullable',
            'sku' => 'required|nullable',
            'img1' => 'required|nullable', 
            'img2' => 'required|nullable',
            'img3' => 'required|nullable',
            'img4' => 'required|nullable',
            'maincolor' => 'required|nullable',
            'size' => 'required|nullable',
            'prodKeywords' => 'required|nullable',
            'saleStartDate' => 'nullable',
            'saleEndDate' => 'nullable',
            'discount' => 'nullable',
            'variety' => 'nullable',
            'contiSelling' => 'nullable',
            'status' => 'nullable',
            'seller_id' => 'nullable',
            'agent_id' => 'nullable',
            'initStock' => 'nullable',
            'updatedBy' => 'nullable',
            'prodDeleted' => 'nullable'
        ]);

        // $files = [];

        // if($request->file('img1')) $files[] = $request->file('img1');
        // if($request->file('img2')) $files[] = $request->file('img2');
        // if($request->file('img3')) $files[] = $request->file('img3');
        // if($request->file('img4')) $files[] = $request->file('img4');

        // foreach ($files as $file) {
        //     if(!empty($file)) {
        //         $filenames[] = $file->getClientOriginalName();
        //         $file->move(base_path() . 'public/product_images', end($filenames));
        //     }
        // }

        $fileNames = array('img1','img2','img3','img4');
        
        $fileCounter = count($fileNames);
        for ($i=0; $i < $fileCounter; $i++) { 
            if($request->hasFile($fileNames[$i])){
                // Get file name with the extension
                $fileNameWithExt = $request->file($fileNames[$i])->getClientOriginalName();
                // Get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // Get just file extension
                $extension = $request->file($fileNames[$i])->getClientOriginalExtension();
                // File to store
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                // Upload image
                $path = $request->file($fileNames[$i])->storeAs('public/product_images', $fileNameToStore);
                
                if($i == 0){
                    if($request->hasFile($fileNames[$i])){
                        $fileNameWithExt = $request->file($fileNames[$i])->getClientOriginalName();
                        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file($fileNames[$i])->getClientOriginalExtension();
                        $img_dir1 = $fileName.'_'.time().'.'.$extension;;
                        $path = $request->file($fileNames[$i])->storeAs('public/product_images', $img_dir1);
                    }
                }
                if($i == 1){
                    if($request->hasFile($fileNames[$i])){
                        $fileNameWithExt = $request->file($fileNames[$i])->getClientOriginalName();
                        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file($fileNames[$i])->getClientOriginalExtension();
                        $img_dir2 = $fileName.'_'.time().'.'.$extension;;
                        $path = $request->file($fileNames[$i])->storeAs('public/product_images', $img_dir2);
                    }
                }
                if($i == 2){
                    if($request->hasFile($fileNames[$i])){
                        $fileNameWithExt = $request->file($fileNames[$i])->getClientOriginalName();
                        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file($fileNames[$i])->getClientOriginalExtension();
                        $img_dir3 = $fileName.'_'.time().'.'.$extension;;
                        $path = $request->file($fileNames[$i])->storeAs('public/product_images', $img_dir3);
                    }
                }
                if($i == 3){
                    if($request->hasFile($fileNames[$i])){
                        $fileNameWithExt = $request->file($fileNames[$i])->getClientOriginalName();
                        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file($fileNames[$i])->getClientOriginalExtension();
                        $img_dir4 = $fileName.'_'.time().'.'.$extension;;
                        $path = $request->file($fileNames[$i])->storeAs('public/product_images', $img_dir4);
                    }
                }
            }
        }
            
        if($validator->fails()){
               return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['img1'] = $img_dir1;
        $input['img1'] = $img_dir2;
        $input['img1'] = $img_dir3;
        $input['img1'] = $img_dir4;
        $input['discount'] = 0;
        $input['variety'] = 0;
        $input['contiSelling'] = 0;
        $input['prodType'] = 'LosodeFriends';
        $input['status'] = 0;
        $product = Products::create($input);
    
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($products)
    {
        $product = Products::find($products);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
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
    public function update(Request $request, $products)
    {
        $product = Products::find($products);
        $input = $request->all();
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->price = $input['price'];
        $product->prodType = $input['prodType'];
        // $product->prodType = $input['prodClass'];
        $product->salesPrice = $input['salesPrice'];
        $product->stock = $input['stock'];
        $product->cat = $input['cat'];
        $product->brandName = $input['brandName'];
        $product->sku = $input['sku'];
        $product->img1 = $input['img1'];
        $product->img2 = $input['img2'];
        $product->img3 = $input['img3'];
        $product->img4 = $input['img4'];
        $product->maincolor = $input['maincolor'];
        $product->size = $input['size'];
        $product->prodKeywords = $input['prodKeywords'];
        $product->saleStartDate = $input['saleStartDate'];
        $product->saleEndDate = $input['saleEndDate'];
        $product->discount =  $input['discount'];;
        $product->variety = $input['variety'];;
        $product->contiSelling = $input['contiSelling'];;
        $product->status = $input['status'];;
        $product->seller_id = $input['seller_id'];
        $product->agent_id = $input['agent_id'];
        $product->initStock = $input['initStock'];
        $product->updatedBy = $input['updatedBy'];
        $product->prodDeleted = $input['prodDeleted'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($products)
    {
        $product = Products::find($products);
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }

    public function imageupload(Request $request)
    {
        //Handle File upload
        if($request->hasFile('cover_image')){
            //Get file name with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just file extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //File to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $post = Post::find($id);
        if($post->cover_image !== 'noimage.jpg'){
            //Delete Existing Image Before Update
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
    }

}

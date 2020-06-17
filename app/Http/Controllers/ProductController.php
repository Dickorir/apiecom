<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }


    public function index()
    {
        return ProductCollection::collection(Product::paginate(5));
    }

    public function store(ProductRequest $request)
    {
        $validated=Validator::make($request->json()->all(),[
            'name' => 'required',
            'detail' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'discount' => 'required',
            'user_id' => 'required',
        ]);
        $data=$validated->validated();

        $product=Product::create($data);
        return response([

            'data' => new ProductResource($product)

        ],Response::HTTP_CREATED);

    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validated=Validator::make($request->json()->all(),[
            'name' => 'required',
            'detail' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'discount' => 'required',
            'user_id' => 'required',
        ]);
        $data=$validated->validated();

//        $this->userAuthorize($product);

//        $request['detail'] = $request->description;

//        unset($request['description']);

        $product->update($data);

        return response([

            'data' => new ProductResource($product)

        ],Response::HTTP_CREATED);

    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response(null,Response::HTTP_NO_CONTENT);
    }

    public function userAuthorize($product)
    {
        if(Auth::user()->id != $product->user_id){
            //throw your exception text here;
            return response('Unauthorized',Response::HTTP_UNAUTHORIZED);
        }
    }

}

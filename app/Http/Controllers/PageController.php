<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function index()
    {
        return view('index')->withTitle('E-COMMERCE STORE | HOME');
    }

    public function blog()
    {
        return view('blog')->withTitle('E-COMMERCE STORE | BLOG');
    }

    public function shop()
    {
        $products = Product::get()->paginate(6);
        $categories = Category::all();
        $brands = Brand::all();

        if(request()->sort == 'low_high'){
            $products = $products->sortBy('price')->paginate(4);
        }
        else if(request()->sort == 'high_low'){
            $products = $products->sortByDesc('price')->paginate(4);
        }
        return view('shop.index')->withTitle('E-COMMERCE STORE | SHOP')->with([
                'products' => $products,
                'categories' => $categories,
                'brands' => $brands
            ]);
    }

    public function category($catId)
    {
        $category = Category::where('id', $catId)->get()->first();
        return view('shop.category')->withTitle('E-COMMERCE STORE | CATEGORY')->with([
            'products' => $category->products,
            'category' => $category
        ]);
    }

    public function brand($brId)
    {
        $brand = Brand::where('id', $brId)->get()->first();
        return view('shop.brand')->withTitle('E-COMMERCE STORE | BRAND')->with([
            'products' => $brand->products,
            'brand' => $brand
        ]);
    }

    public function product($proId)
    {
        $product = Product::where('slug', $proId)->get()->first();
        $mightLike = Product::where('slug', '!=', $proId)
//                    ->where('category_id', $product->category->id)
//                    ->where('name', 'like', '%'.$product->name.'%')
                    ->where('brand_id', $product->brand)
                    ->get();

        return view('shop.product')->withTitle('E-COMMERCE STORE | PRODUCT')->with([
            'product' => $product,
            'mightLike' => $mightLike
        ]);
    }

    public function search(Request $request){
        if($request->ajax()) {
            $data = Product::where('name', 'LIKE', '%'.$request->search.'%')->get();
//            dd($data);
            $output = '';
            if (count($data)>0) {
                $output = '<ul
                            class="list-group"
                            style="position: absolute; z-index: 10000; width: 700px; cursor: pointer;"
                        >';
                foreach ($data as $row){
                    $output .= '<li class="list-group-item">'.
                        '<img class="img-thumbnail" style="width: 50px; height: 50px; margin-right: 50px;" src="/images/'.$row->image_path.'">'.
                        $row->name.
                        '</li>';
                }
                $output .= '</ul>';
            }
            else {
                $output .= '<li class="list-group-item" style="position: absolute; z-index: 10000; width: 700px; cursor: pointer;">'.'No results'.'</li>';
            }
            return $output;
        }
    }

    public function search_results(Request $request){
        $data = Product::where('name', 'LIKE', '%'.$request->search.'%')->get();
        return view('shop.search')->withTitle('E-COMMERCE STORE | SEARCH')->with(['results' => $data]);
    }

    public function search_price(Request $request){
        $data = Product::where('price', '>=', $request->min)->where('price', '<=', $request->max)->get();
//        dd($data);
        return view('shop.search')->withTitle('E-COMMERCE STORE | SEARCH')->with(['results' => $data]);
    }

    public function about()
    {
        return view('about')->withTitle('E-COMMERCE STORE | ABOUT');
    }

}

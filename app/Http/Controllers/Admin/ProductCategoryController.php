<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Database\Factories\ProductFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    //
    public function index(Request $request){
        // $page = $_GET['page'] ?? 1;

        // Tim kiem keyword Hoac Tim giam va tang
        $keyword = $request->keyword ?? '';

        $sortBy = $request->sortBy ?? 'latest';
        $status = $request->status ?? '';
        $sort = ($sortBy === 'oldest') ? 'asc' : 'desc';

        $filter = [];//'select * from product_categories  where name like ? order by created_at (desc or asc) limit ?,?'
        if(!empty($keyword)){
            $filter[]=['name','like', '%'.$keyword.'%'];
        }

        if($status !== ''){
            $filter[] = ['status', $status];
        }


        // $page = $request->page ?? 1;
        // $itemPerPage = 2;
        // $offset = ($page - 1) * $itemPerPage;

        // $sqlSelect = 'select * from product_categories';
        // $paramsBinding = [];
        // if(!empty($keyword)){
        //     $sqlSelect .= ' where name like ? ';
        //     $paramsBinding[] = '%'.$keyword.'%';

        // }
        // $sqlSelect .= ' order by created_at ' . $sort;
        // $sqlSelect .= ' limit ?,?';
        // $paramsBinding[] =  $offset;
        // $paramsBinding[] =  $itemPerPage;
        // // select * from product_categories  order by created_at $sort limit ?,?




        // $productCategories = DB::select( $sqlSelect, $paramsBinding);

        // $totalRecords = DB::select('select count(*) as sun from product_categories')[0]->sun;

        //--------------------------------------------------
        // $totalPages = ceil($totalRecords / $itemPerPage);
        //--------------------------------------------------
        //Eloquent
        // $productCategories = ProductCategory::paginate(config('my-config.item-per-pages'));
        $productCategories = ProductCategory::where($filter)
        ->orderBy('created_at',$sort)
        ->paginate(config('my-config.item-per-pages'));

        return view('admin.pages.productCategory.list',
        [
        'productCategories' => $productCategories,
        //  'totalPages' => $totalPages,
         'keyword' => $keyword,
         'sortBy' => $sortBy

        ]);

        // return view('admin.pages.productCategory.list', compact($productCategories));
        // return view('admin.pages.productCategory.list')->with('productCategories', $productCategories);

    }
    public function add(){
        return view('admin.pages.productCategory.create');
    }
    public function store(StoreProductCategoryRequest $request){

        //SQL Raw
        // $bool = DB::insert('INSERT into product_categories(name, status, created_at, updated_at) values (?, ?, ?, ?)', [
        //     $request->name,
        //     $request->status,
        //     Carbon::now()->addDay(999)->addMonth()->addYear(),
        //     Carbon::now()
        // ]);
        // dd('thanh cong');
        // dd($request->all());
        // $name = $request->name;
        // $status = $request->status;

         //Eloquent
         $productCategory = new ProductCategory;
         $productCategory->name = $request->name;
         $productCategory->status = $request->status;
         $check = $productCategory->save();

        $message = $check ? 'Tao thanh cong' : 'Tao that bai';

        //Session flash
        return redirect()->route('admin.productCategory.list')->with('message', $message);
    }
    public function detail(ProductCategory $productCategory){

        // $productCategory = DB::select('select * from product_categories where id = ?', [$id]);
        //Eloquent
        // $productCategory = ProductCategory::find($product_category);
        return view('admin.pages.productCategory.detail', ['productCategory' => $productCategory]);

    }
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory){


        // dd($request->all());

        // $check = DB::update('UPDATE `product_categories` SET name = ? , status = ?  WHERE id = ? ', [$request->name, $request->status, $id]);

        //Eloquent
        // $productCategory = ProductCategory::find($id);
        $productCategory->name = $request->name;
        $productCategory->status = $request->status;
        $check = $productCategory->save();

        $message = $check > 0 ? 'Cap nhat thanh cong' : 'Cap nhat that bai';
         //Session flash
        return redirect()->route('admin.productCategory.list')->with('message',$message);

    }
    public function destroy(ProductCategory $productCategory){
        // $check = DB::delete('delete from product_categories where id = ? ', [$id]);

        //Eloquent
        $check = $productCategory->delete();
        $message = $check > 0 ? 'Xoa thanh cong' : 'Xoa that bai';
        //Session flash
       return redirect()->route('admin.productCategory.list')->with('message',$message);
    }
}

<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Displays list of the products
     *
     * @return $this
     */
    public function index()
    {
        $model = Product::all();

        return view('product.index')
            ->with(['model' => $model]);
    }

    /**
     * Creates new product
     *
     * @param Request $request
     * @return $this|Redirect
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'slug' => 'required'
            ]);
            if ($validator->fails()) {
                Session::flash('error', 'Ошибка валидации');
                return Redirect::to('admin/product/add')
                    ->withErrors($validator);
            } else {
                $model = new Product();
                $model->name = $request->input('name');
                $model->description = $request->input('description');
                $model->price = $request->input('price');
                $model->save();
                /* product to category */
                if (! empty($request->input('category_id'))) {
                    $pc = new ProductCategory();
                    $pc->product_id = $model->id;
                    $pc->category_id = $request->input('category_id');
                    $pc->save();
                }
                Session::flash('success', 'Товар сохранен');

                return redirect(route('product_list'));
            }
        }

        $form_action = route('product_add');
        $category_list = Category::getCategoryList();

        return view('product.form')
            ->with([
                'form_action' => $form_action,
                'category_list' => $category_list
            ]);
    }

    /**
     * Updates existing product
     *
     * @param Request $request
     * @param $id
     * @return $this|Redirect
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required'
            ]);
            if ($validator->fails()) {
                Session::flash('error', 'Ошибка валидации');
                return Redirect::to('admin/product/add')
                    ->withErrors($validator);
            } else {
                $model = Product::find($id);
                $model->name = $request->input('name');
                $model->description = $request->input('description');
                $model->price = $request->input('price');
                $model->slug = $request->input('slug');
                $model->save();
                /* product to category */
                if (! empty($request->input('category_id'))) {
                    $pc = new ProductCategory();
                    $pc->product_id = $model->id;
                    $pc->category_id = $request->input('category_id');
                    $pc->save();
                } else {
                    ProductCategory::where('product_id', $id)
                        ->delete();
                }
                Session::flash('success', 'Товар сохранен');

                return redirect(route('product_list'));
            }
        }

        $form_action = route('product_update', ['id' => $id]);
        $category_list = Category::getCategoryList();
        $model = Product::find($id);
        $category_id = (ProductCategory::where(['product_id' => $id])->first()) ? ProductCategory::where(['product_id' => $id])->first()->category_id : null;

        return view('product.form')->with([
            'form_action' => $form_action,
            'category_list' => $category_list,
            'category_id' => $category_id,
            'model' => $model
        ]);
    }
}

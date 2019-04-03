<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $formInputList;
    private $baseRouteName = 'product';
    private $modelUsing    = Product::class;
    private $title         = 'Product Management';
    private $tableColumn   = [
        'productCategory->name' => 'Category Name',
        'company->name'         => 'Company Name',
        'RFID'                  => 'RFID',
        'name'                  => 'Product Name',
        'deadstock_period'      => 'Deadstock Period',
    ];
    private $rules = [
        'product_category_id' => 'required|exists:product_categories,id',
        'company_id'          => 'required|exists:companies,id',
        'RFID'                => 'required|unique:products',
        'name'                => 'required|max:255|string',
        'deadstock_period'    => 'required|integer|min:1',
    ];

    public function __construct() {
        $this->middleware('auth');
        $this->formInputList  = [
            'Category Name' => [
                'name'    => 'product_category_id',
                'type'    => 'select',
                'options' => ProductCategory::get()->pluck('id', 'name'),
            ],
            'Company Name' => [
                'name'    => 'company_id',
                'type'    => 'select',
                'options' => Company::get()->pluck('id', 'name'),
            ],
            'RFID' => [
                'name' => 'RFID',
                'type' => 'number',
            ],
            'Product Name' => [
                'name' => 'name',
                'type' => 'text',
            ],
            'Deadstock Period' => [
                'name' => 'deadstock_period',
                'type' => 'number',
            ],
        ];
    }

    public function index() {
        $variables = [
            'title'         => $this->title,
            'itemList'      => $this->modelUsing::get(),
            'baseRouteName' => $this->baseRouteName,
            'formInputList' => $this->formInputList,
            'tableColumn'   => $this->tableColumn,
        ];
        return view('crud.template', $variables);
    }

    public function store(Request $request) {
        $this->validate($request, $this->rules);

        $inputs                    = $request->all();
        $item                      = new $this->modelUsing;
        $item->product_category_id = $inputs['product_category_id'];
        $item->company_id          = $inputs['company_id'];
        $item->RFID                = $inputs['RFID'];
        $item->name                = $inputs['name'];
        $item->deadstock_period    = $inputs['deadstock_period'];
        $item->save();
        return redirect()->back()->with('success', 'Added !');
    }

    public function show($id) {
        $item = $this->modelUsing::find($id);
        if($item) {
            return $item->toJson();
        }
        return [];
    }

    public function update(Request $request, $id) {
        $item = $this->modelUsing::find($id);
        if($item) {
            $rules         = $this->rules;
            $rules['RFID'] = 'required|unique:products,RFID,'.$id;
            $this->validate($request, $rules);

            $inputs                    = $request->all();
            $item->product_category_id = $inputs['product_category_id'];
            $item->company_id          = $inputs['company_id'];
            $item->RFID                = $inputs['RFID'];
            $item->name                = $inputs['name'];
            $item->deadstock_period    = $inputs['deadstock_period'];
            $item->save();
            return redirect()->back()->with('success', 'Edited !');
        }
        return redirect()->back()->with('error', 'Error !');
    }

    public function destroy($id) {
        $item = $this->modelUsing::find($id);
        if($item) {
            $item->delete();
            return redirect()->back()->with('success', 'Deleted !');
        }
        return redirect()->back()->with('error', 'Error !');
    }
}

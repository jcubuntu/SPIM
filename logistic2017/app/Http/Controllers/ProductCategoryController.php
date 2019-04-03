<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    private $formInputList;
    private $baseRouteName = 'category';
    private $modelUsing    = ProductCategory::class;
    private $title         = 'Product Category Management';
    private $tableColumn   = [
        'name' => 'Category Name',
    ];
    private $rules = [
        'name' => 'required|string|max:255',
    ];

    public function __construct() {
        $this->middleware('auth');
        $this->formInputList  = [
            'Category Name' => [
                'name' => 'name',
                'type' => 'text',
            ],
        ];
    }

    public function index() {
        $itemList  = $this->modelUsing::get();
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

        $item = new $this->modelUsing;
        $item->name = $request->input('name');
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
            $this->validate($request, $this->rules);

            $inputs     = $request->all();
            $item->name = $inputs['name'];
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

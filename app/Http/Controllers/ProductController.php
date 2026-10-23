<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Vendor;
use App\Http\Requests\ProductStoreRequest;

class ProductController extends Controller {

    public function index(Request $request) {
        //  一覧画面用のバリデーションを追加
        $request->validate([
            'sort' => 'nullable|in:asc,desc,created_at_desc,updated_at_desc',
        ]);
        // クエリビルダのインスタンスを作成
        $query = DB::table('products');

        // ① 条件で絞り込み（商品名の部分一致検索）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('product_name', 'like', "%{$keyword}%");
        }

        // ② 条件に応じた並べ替え
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            
            //  ユーザーの選択に応じて、並び替えるカラムと順序を切り替えます
            switch ($sort) {
                case 'asc':
                    $query->orderBy('price', 'asc'); // 価格の安い順
                    break;
                case 'desc':
                    $query->orderBy('price', 'desc'); // 価格の高い順
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc'); // 作成日時の新しい順
                    break;
                case 'updated_at_desc':
                    $query->orderBy('updated_at', 'desc'); // 更新日時の新しい順
                    break;
            }
        } else {
            // デフォルトの並べ替え（作成日時の古い順、または id 順）
            $query->orderBy('created_at', 'asc');
        }

        // 最終的なクエリを実行してデータを取得
        $products = $query->get();

        return view('products.index', compact('products'));
    }

    // 詳細画面
    public function show($id) {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    // 登録画面
    public function create() {
        $vendor_codes = Vendor::pluck('vendor_code');
        return view('products.create', compact('vendor_codes'));
    }

    // 保存処理
    public function store(ProductStoreRequest $request) {
        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->vendor_code = $request->input('vendor_code');
        $product->save();

        return redirect("/products/{$product->id}");
    }
}

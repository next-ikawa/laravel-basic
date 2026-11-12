<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧ページを表示する
     */
    public function index()
    {
        // セッションから商品IDの配列を取得（未設定の場合は空配列）
        $favoriteIds = session('favorites', []);

        // セッション内のIDに一致する商品データを取得
        $products = Product::whereIn('id', $favoriteIds)->get();

        return view('favorites.index', compact('products'));
    }

    /**
     * お気に入り選択ページを表示する
     */
    public function create()
    {
        // すべての商品を取得してビューに渡す
        $products = Product::all();

        return view('favorites.create', compact('products'));
    }

    /**
     * 送信された商品IDをセッションに保存する
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = (int) $request->input('product_id');

        // 現在のセッションからお気に入りリストを取得
        $favorites = session('favorites', []);

        // 重複していなければ配列に追加してセッションを更新
        if (!in_array($productId, $favorites, true)) {
            $favorites[] = $productId;
            session(['favorites' => $favorites]);
        }

        return redirect()->route('favorites.index');
    }

    /**
     * 送信された商品IDをセッションから削除する
     */
    public function destroy(Request $request)
    {
        $productId = (int) $request->input('product_id');

        // 現在のセッションからお気に入りリストを取得
        $favorites = session('favorites', []);

        // 該当する商品IDを除外し、配列のインデックスを振り直す
        $favorites = array_values(array_diff($favorites, [$productId]));

        // 更新した配列をセッションに保存
        session(['favorites' => $favorites]);

        return redirect()->route('favorites.index');
    }
}

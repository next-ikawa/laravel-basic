<!DOCTYPE html>
<html lang="ja">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Laravel基礎</title>
</head>

<body>
   <!--  ここから：検索・並べ替えのフォームを追加 -->
   <form action="{{ route('products.index') }}" method="GET" style="margin-bottom: 20px; padding: 10px; background: #f5f5f5; border-radius: 4px;">
       <!-- ① 商品名の絞り込み -->
       <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索" style="padding: 5px;">

       <!-- ② 価格の並べ替え -->
       <select name="sort" style="padding: 5px;">
           <option value="">並べ替え（デフォルト）</option>
           <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>価格の安い順</option>
           <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>価格の高い順</option>
           <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>作成日時の新しい順</option>
           <option value="updated_at_desc" {{ request('sort') == 'updated_at_desc' ? 'selected' : '' }}>更新日時の新しい順</option>
       </select>

       <button type="submit" style="padding: 5px 10px;">検索</button>
       <a href="{{ route('products.index') }}" style="margin-left: 10px; color: #666; text-decoration: none;">クリア</a>
   </form>
   <!--  ここまで -->

   <!-- 既存のテーブル構造 -->
   <table border="1" style="border-collapse: collapse; width: 100%;">
       <tr>
           <th>ID</th>
           <th>商品名</th>
           <th>価格</th>
           <th>作成日時</th>
           <th>更新日時</th>
           <th>操作</th>
       </tr>
       @forelse($products as $product)
           <tr>
               <td>{{ $product->id }}</td>
               <td>{{ $product->product_name }}</td>
               <td>{{ $product->price }}</td>
               <td>{{ $product->created_at }}</td>
               <td>{{ $product->updated_at }}</td>
               <!-- ★「操作」のマスを中央揃えにして、中のフォームもブロック化して安定させました -->
               <td style="text-align: center; vertical-align: middle;">
                   <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="margin: 0; display: inline-block;">
                       @csrf
                       @method('DELETE')
                       <button type="submit" style="color: red; cursor: pointer; padding: 2px 8px;">削除</button>
                   </form>
               </td>
           </tr>
       @empty
           <!--  データが0件だった場合の表示を指定 -->
           <tr>
               <td colspan="6" style="text-align: center; padding: 20px; color: #666;">
                   該当する商品名がございません
               </td>
           </tr>            
       @endforelse       
   </table>

   <!-- ⇩⇩⇩ ★ここから新しく「ゴミ箱（復元エリア）」を追加しました ★ ⇩⇩⇩ -->
   <h2 style="margin-top: 40px; color: #666;">削除済みの商品（ゴミ箱）</h2>
   <table border="1" style="border-collapse: collapse; width: 100%; border-color: #ccc; background-color: #fafafa;">
       <tr style="background-color: #eee; color: #555;">
           <th>ID</th>
           <th>商品名</th>
           <th>価格</th>
           <th>操作</th>
       </tr>
       @forelse($trashed_products as $trashed)
           <tr>
               <td>{{ $trashed->id }}</td>
               <td style="color: #888; text-decoration: line-through;">{{ $trashed->product_name }}</td>
               <td>{{ $trashed->price }}</td>
               <td style="text-align: center; vertical-align: middle;">
                   <!-- 元に戻す（復元）ボタンのフォーム -->
                   <form action="{{ route('products.restore', $trashed->id) }}" method="POST" style="margin: 0; display: inline-block;">
                       @csrf
                       @method('PATCH')
                       <button type="submit" style="color: green; cursor: pointer; padding: 2px 8px;">元に戻す</button>
                   </form>
               </td>
           </tr>
       @empty
           <tr>
               <td colspan="4" style="text-align: center; padding: 15px; color: #999;">
                   ゴミ箱は空です
               </td>
           </tr>
       @endforelse
   </table>
   <!-- ⇧⇧⇧ ★ここまで追加 ★ ⇧⇧⇧ -->

</body>

</html>

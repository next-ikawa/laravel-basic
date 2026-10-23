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
       </tr>
       @forelse($products as $product)
           <tr>
               <td>{{ $product->id }}</td>
               <td>{{ $product->product_name }}</td>
               <td>{{ $product->price }}</td>
               <td>{{ $product->created_at }}</td>
               <td>{{ $product->updated_at }}</td>

               <!--  データが0件だった場合の表示を指定 -->
       @empty
           <tr>
               <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                   該当する商品名がございません
               </td>
           </tr>            
       @endforelse       
   </table>
</body>

</html>
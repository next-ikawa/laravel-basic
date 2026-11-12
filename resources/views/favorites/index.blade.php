<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り一覧</title>
</head>
<body>
    <h1>お気に入り商品一覧</h1>

    <p>
        <a href="{{ route('favorites.create') }}">お気に入り選択ページへ</a>
    </p>

    @if ($products->isEmpty())
        <p>お気に入りに登録されている商品はありません。</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>仕入先コード</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->price) }}円</td>
                        <td>{{ $product->vendor_code }}</td>
                        <td>
                            <form action="{{ route('favorites.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit">お気に入りを解除する</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>

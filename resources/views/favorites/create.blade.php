<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り選択</title>
</head>
<body>
    <h1>お気に入り商品の選択</h1>

    <form action="{{ route('favorites.store') }}" method="POST">
        @csrf
        <div>
            <label for="product_id">商品を選択してください：</label>
            <select name="product_id" id="product_id" required style="width: 300px; padding: 8px; font-size: 16px;">
                <option value="">-- 商品を選択 --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->product_name }}（{{ number_format($product->price) }}円）
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-top: 16px;">
            <button type="submit">お気に入りに追加する</button>
        </div>
    </form>

    <p style="margin-top: 24px;">
        <a href="{{ route('favorites.index') }}">お気に入り一覧へ戻る</a>
    </p>
</body>
</html>


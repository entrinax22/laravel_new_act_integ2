
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Products Catalog</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h1 {
            color: #252542;
        }

        .subtitle {
            color: #777;
            margin-bottom: 25px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 18px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: contain;
        }

        .card h3 {
            font-size: 16px;
        }

        .price {
            color: #2563eb;
            font-weight: bold;
        }

        .category {
            color: #777;
            font-size: 13px;
        }

        .error {
            padding: 15px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>External Product Catalog</h1>

    <p class="subtitle">
        Product information retrieved from DummyJSON API
    </p>

    @if ($error)
        <div class="error">
            {{ $error }}
        </div>
    @else

        <p>
            Total Products Retrieved: {{ $products->count() }}
        </p>

        <div class="products">

            @foreach ($products as $product)

                <div class="card">

                    @if ($product['image'])
                        <img
                            src="{{ $product['image'] }}"
                            alt="{{ $product['name'] }}"
                        >
                    @endif

                    <h3>{{ $product['name'] }}</h3>

                    <p class="category">
                        {{ $product['category'] }}
                    </p>

                    <p class="price">
                        ${{ number_format($product['price'], 2) }}
                    </p>

                    <small>
                        Product ID: {{ $product['id'] }}
                    </small>

                </div>

            @endforeach

        </div>

    @endif

</div>

</body>
</html>

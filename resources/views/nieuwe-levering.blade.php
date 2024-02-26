<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/store-avatar.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>{{ $title }}</title>
</head>

<body>

<div class="logo">
    <a href="{{ url('/') }}">
        <img src="{{ asset('img/logo-wit.png') }}">
    </a>
</div>

<div class="card">
    <div class="title">
        <h1>
            {{ $title }}
        </h1>
    </div>
    <h3>
        Leverancier: <span>{{ $naamLeverancier }}</span>
    </h3>
    <h3>
        Contactpersoon: <span>{{ $contactPersoon }}</span>
    </h3>
    <h3>
        Mobiel: <span>{{ $mobiel }}</span>
    </h3>
    <form method="post" action="{{route('nieuwe-leveringen.store')}}">
        @csrf
        @method('POST')
        <input type="hidden" name="leverancier_id" value="{{ $leverancierId }}">
{{--        <input type="hidden" name="product_id" value="{{ $productId }}">--}}
        <label for="aantal">Aantal producteenheden</label>
        <input type="number" name="aantal" id="aantal" placeholder="20" min="1"><br>
        <label for="evl">Datum eerstvolgende levering</label>
        <input type="date" name="evl" id="evl">
        <input type="submit" value="Sla op" id="add">
    </form>

</div>

<script src="{{ asset('js/column.js') }}"></script>

</body>

</html>

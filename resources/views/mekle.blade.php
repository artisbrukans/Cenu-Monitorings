<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meklē</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="container">
    <h1>Meklē</h1>
    <form action="{{ url('/mekle') }}" method="POST">
        @csrf
        <div class="form-section">
            <input type="text" id="svitrkods" name="svitrkods" required>
        </div>
        <br>
        <table>
            <tr>
                <th>Svitrkods</th>
                <th>Produkta Nosaukums</th>
                <th>Daudzums</th>
                <th>Mervieniba</th>
                <th>Datums</th>
                <th>Veikala nosaukums</th>
                <th>Iela</th>
                <th>Pilsēta</th>
                <th>Valsts</th>
                <th>Cena par vienu</th>
                <th>Cena par vienību</th>
                <th>Akcijas Spēka Datums</th>
                <th>Akcijas Cena</th>
            </tr>
            @if($product->isEmpty())
                <tr>
                    <td colspan="13">Šāds produkts nav pievienots</td>
                </tr>
            @else
                @foreach($product as $prod)
                    <tr>
                        <td>{{ $prod->Svitrkods }}</td>
                        <td>{{ $prod->Produkts_Nosaukums }}</td>
                        <td>{{ $prod->Daudzums }}</td>
                        <td>{{ $prod->Mervieniba }}</td>
                        <td>{{ $prod->Datums }}</td>
                        <td>{{ $prod->Veikals_Nosaukums }}</td>
                        <td>{{ $prod->Iela }}</td>
                        <td>{{ $prod->Pilseta }}</td>
                        <td>{{ $prod->Valsts }}</td>
                        <td>{{ $prod->CenaParVienu }}</td>
                        <td>{{ $prod->CenaParVienibu }}</td>
                        <td>{{ $prod->AkcijaSpeka }}</td>
                        <td>{{ $prod->AkcijasCena }}</td>
                    </tr>
                @endforeach
            @endif
        </table>

        <div class="buttons">
            <button type="submit" class="button">Meklēt</button>
            <a href="{{ url('/') }}" class="button">Atpakaļ</a>
        </div>
    </form>


</div>
</body>
</html>

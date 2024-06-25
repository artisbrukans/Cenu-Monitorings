<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.search')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="container">
    <h1>@lang('messages.search')</h1>
    <form action="{{ url('/mekle') }}" method="POST">
        @csrf
        <div class="form-section">
            <input type="text" id="svitrkods" name="svitrkods" required>
        </div>
        <br>
        <table>
            <tr>
                <th>@lang('messages.barcode')</th>
                <th>@lang('messages.prname')</th>
                <th>@lang('messages.count')</th>
                <th>@lang('messages.measure')</th>
                <th>@lang('messages.date')</th>
                <th>@lang('messages.shname')</th>
                <th>@lang('messages.street')</th>
                <th>@lang('messages.city')</th>
                <th>@lang('messages.country')</th>
                <th>@lang('messages.one')</th>
                <th>@lang('messages.unit')</th>
                <th>@lang('messages.limit')</th>
                <th>@lang('messages.sale')</th>
            </tr>
            @if($product->isEmpty())
                <tr>
                    <td colspan="13">@lang('messages.no')</td>
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
            @if(Auth::check())
                @if(Auth::user()->isAdmin())
                    <button type="submit" class="button">@lang('messages.search')</button>
                    <a href="{{ url('admin.dashboard') }}" class="button">@lang('messages.back')</a>
                @else
                    <button type="submit" class="button">@lang('messages.search')</button>
                    <a href="{{ url('/dashboard') }}" class="button">@lang('messages.back')</a>
                @endif
            @else
                <button type="submit" class="button">@lang('messages.search')</button>
                <a href="{{ url('/') }}" class="button">@lang('messages.back')</a>
            @endif
        </div>
    </form>


</div>
</body>
</html>

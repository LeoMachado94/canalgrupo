<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="#">
    <title>Relatório - {{ date('Y-m-d') }} - {{ $client->name }}</title>
    <link rel="icon" href="{{ asset('template/favicon.png') }}" type="image/png">
    {{-- Bootstrap via CDN deixava o dompdf ~6x mais lento; só as classes usadas abaixo --}}
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #212529;
        }
        .p-3 {
            padding: 1rem;
        }
        .container-fluid {
            width: 100%;
            padding: 0 15px;
        }
        .card-header {
            padding: .75rem 1.25rem;
        }
        .bg-danger {
            background-color: #dc3545;
        }
        .text-white {
            color: #fff;
        }
        hr {
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
            margin: 1rem 0;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }
        .btn-link {
            color: #E54B39;
            text-align: center;
            border: none;
            display: block;
            text-decoration: none;
        }
        .table tr, .table td {
            border-bottom: 1px solid #AAA;
            padding: 2px;
            padding-left: 10px;
        }
        .table th {
            text-align: left;
            padding-left: 10px;
        }
        .table .subtitle {
            background: #CCC;
            color: #000;
            font-weight: bold;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header class="p-3">
        <img src="http://canalgrupo.tk/template/assets/img/brand/logo.svg">
    </header>
    <main>
    <div class="container-fluid">
        <div class="card-header bg-danger text-white">Relatório de Clippings - Cliente: {{ $client->name }}</div>
        <table>
            <tbody>
            <tr>
                <td width="33%"><strong>Exibição:</strong> {{ $exhibition->name ?? '' }}</td>
                <td width="33%"><strong>Meio:</strong> {{ $middle->name ?? '' }}</td>
                <td width="33%"><strong>Classificação:</strong> {{ $classification->name ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="3">Veiculação entre <strong>{{ $start_date_formatted }}</strong> e <strong>{{ $end_date_formatted }}</strong></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <table style="width: 700px;">
            <tr>
                <td width="700" style="width: 700px;">
                    <img src="{{ $chart1 }}" width="700">
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td width="340" style="width:300px;"><img src="{{ $chart2 }}" width="340"></td>
                <td width="340" style="width:300px;"><img src="{{ $chart3 }}" width="340"></td>
            </tr>
        </table>
        <br>
        <table class="table">
            <thead>
            <tr>
                <th>Data cad.</th>
                <th>Veículo</th>
                <th>Editorial</th>
                <th>Classificação</th>
                <th>Fonte</th>
                <th>Acesso</th>
            </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                    <tr><td colspan="6" class="subtitle">{{ $subject->first()->subject->title }}</td></tr>
                    @foreach($subject as $clipping)
                    <tr>
                        <td>{{ $clipping->date }}</td>
                        <td>{{ $clipping->vehicle->name ?? '' }}</td>
                        <td>{{ $clipping->editorial->title ?? '' }}</td>
                        <td>{{ $clipping->classification->name ?? '' }}</td>
                        <td>{{ $clipping->source->name ?? '' }}</td>
                        <td>
                            @php($url = route('external.clippings.show', $clipping->slug))
                            {!! "<a href='{$url}' target='_blank' class='btn-link'>Acesse aqui</a>" !!}
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
{{--            <div class="alert alert-danger">Nenhum clipping encontrado.</div>--}}
    </div>
    </main>
</body>

</html>

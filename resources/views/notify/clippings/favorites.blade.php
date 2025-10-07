<h3 style="color:#000;">Prezados,</h3>

@php($period = date('d/m/Y'))
<p style="color:#000;">Segue clipping com notícias de interesse da <span style="font-weight:bold;">{{ $client->name }}</span> referente ao dia <span style="font-weight:bold;">{{ $period }}</span></p>

<table class="table">
    <thead>
    <tr>
        <th style="background: #E54B39; color: #FFF; padding: 3px;">Data</th>
        <th style="background: #E54B39; color: #FFF; padding: 3px;">Veículo</th>
        <th style="background: #E54B39; color: #FFF; padding: 3px;">Editorial</th>
        <th style="background: #E54B39; color: #FFF; padding: 3px;">Classificação</th>
        <th style="background: #E54B39; color: #FFF; padding: 3px;">Fonte</th>
        <th style="background: #E54B39; color: #FFF; padding: 3px;">Assunto</th>
        <th style="background: #E54B39; color: #FFF; padding: 3px;">Acesso</th>
    </tr>
    </thead>
    <tbody>
        @php($i=1)
        @foreach($favorites as $fav)
            <tr style="@if($i%2==0) background-color: #f2f2f2; @endif color: #000;">
                <td>{{ $fav->date }}</td>
                <td>{{ $fav->vehicle->name ?? '' }}</td>
                <td>{{ $fav->editorial->title ?? '' }}</td>
                <td>{{ $fav->classification->name ?? '' }}</td>
                <td>{{ $fav->source->name ?? '' }}</td>
                <td>{{ $fav->subject->title ?? '' }}</td>
                <td>
                    @php($url = route('external.clippings.show', $fav->slug))
                    {!! "<a href='{$url}' target='_blank' class='btn-link' style='color: #E54B39; text-align: center; border: none; display: block; text-decoration: none;'>Acesse aqui</a>" !!}
                </td>
            </tr>
            @php($i++)
        @endforeach
    </tbody>
</table>
<p></p>
<p style="color:#000;">Att,</p>
<p style="color:#000;">Equipe de Monitoramento</p>
<p style="color:#000;">Canal Grupo</p>

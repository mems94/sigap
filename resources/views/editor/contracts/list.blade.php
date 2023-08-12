@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('title', 'SIGAP')
    
@section('content')
    <div class="text-center my-4">
        <h4 class="my-4">Historique des contrats</h4>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Ancien</th>
                    <th>Nouveau</th>
                    <th>Date de modification</th>
                </tr>
            </thead>
            @foreach ($histories as $history)
                @php
                    $data = json_decode($history->meta, true);
                @endphp
                @if ($history->meta)
                    <tbody>
                        <tr>
                            <td>{{ $data[0]['old'] }}</td>  
                            <td>{{ $data[0]['new'] }}</td>  
                            <td>{{ Carbon::parse($history->performed_at)->format('d/m/Y') }}</td>   
                        </tr>
                    </tbody>
                @else
                    <h5 class="text-danger">Pas d'historique de modification pour ce contrat</h5>
                @endif
            @endforeach
        </table>
    </div>
@endsection
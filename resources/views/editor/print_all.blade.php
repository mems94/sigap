@extends('layouts.app')

@section('title', 'SIGAP')

@section('content')
    <div class="container-md my-4">
      <div class="col-md-8 mx-auto">
        <h3 class="fw-bold text-center">Etat d'avancement des employés</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenoms</th>
                    <th>Avancement de classe</th>
                    <th>Avancement d'echelon</th>
                </tr>
            </thead>
          <tbody>
            @foreach ($employees as $employee)
              <tr>
                <td>{{ $employee->lastName }}</td>
                <td>{{ $employee->firstName }}</td>
                <td>{{ $employee->contracts[0]->endDate }}</td>
                <td>{{ $employee->contracts[0]->endDate }}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
  </div>
@endsection
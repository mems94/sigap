@php
/** 
 * Import class Carbon for datetime processing
*/
    use Carbon\Carbon;
    $nextClassAdvancement = '-';
    $pos = 0;

    // dd($employees[0]->contracts[0]->avenants[0]->avenantNumber);

@endphp

@extends('layouts.app')

@section('title', 'SIGAP')

@section('content')
    <div class="d-flex justify-content-between my-2" >

        <div class="text-center rounded-3">
            <form action="" method="get" class= "container d-flex gap-2">
                <input class="form-control" type="text" name="lastName" id="lastName" placeholder="Rechercher un nom" value="{{ $inputForSearch['lastName'] ?? '' }}">
                <input class="form-control" type="number" name="im" id="im" placeholder="Rechercher un IM" value="{{ $inputForSearch['im'] ?? '' }}">
                <button>
                    <i class="bi bi-search fs-3 text-primary mx-3"></i>
                </button>
            </form>
        </div>
        
        <div>
            <a href="#" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Imprimer pour tous les employés"><i class="bi bi-printer-fill fs-1 text-primary mx-3"></i></a>
            
            @can('create', Auth::user())
                <a href="{{ route('editor.employee.create') }}"><i class="bi bi-plus-circle-fill fs-1 text-primary"></i></a>
            @endcan

        </div>
    </div>

    <div class="row justify-content-center">
            <table class="table table-responsive table-bordered text-center">
                <thead>
                    <tr>
                        <th>Pos</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Immatricule</th>
                        <th>Numero Contrat</th>
                        <th>Date Contrat</th>
                        <th>Classe</th>
                        <th>Avancement de classe</th>
                        <th>Echelon</th>
                        <th>Avancement d'echelon</th>
                        <th>Date prochain contrat</th>
                        <th class="fw-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse ($employees as $employee)
                        @php
                        /**
                         * To show employee position through the list
                        */
                            $pos = $pos + 1;
                        @endphp
                        <tr>
                            <td> {{ $pos }}</td>
                            <td> {{ $employee->lastName }}</td>
                            <td> {{ $employee->firstName }}</td>
                            <td> {{ $employee->im }}</td>
                            <td> {{ $employee->contracts[0]->contractNumber }}<a href="{{ route('editor.contracts.list', $employee->contracts[0]) }}"><i class="bi bi-list-ul fs-4 text-primary mx-2"></i></a></td>

                            <td> {{ Carbon::parse($employee->contract?->startDate)->format('d-m-Y') }}</td>
                            <td> {{ $employee->advancements[0]->class }}</td>

                            @php
                            /** 
                             * Advancement evolution rules
                             * Check for echelon below
                            */
                                if (!$employee->contracts[0]->avenants[0]?->avenantNumber) {
                                    $nextClassAdvancement = Carbon::parse($employee->contracts[0]->startDate)->addYear();
                                } else {
                                    $nextClassAdvancement = Carbon::parse($employee->contracts[0]->avenants[0]->date)->addYears(3);
                                }  
                                $nextEchelonAdvancement = Carbon::parse($employee->contracts[0]->startDate)->addYear();
                            @endphp

                            <td @if ($nextClassAdvancement->diffInMonths(Carbon::now()) <= 2)
                                    class = "bg-danger text-white"
                                @endif > {{ $nextClassAdvancement->format('d-m-Y') }}
                            </td>

                            <td>{{ $employee->advancements[0]->echelon }} </td>

                            <td @if ($nextEchelonAdvancement->diffInMonths(Carbon::now()) <= 2)
                                    class = "bg-danger text-white"
                                @endif >
                                {{ $nextEchelonAdvancement->format('d-m-Y') }}
                            </td>

                            <td @if (Carbon::parse($employee->contracts[0]->endDate)->diffInDays(Carbon::now()) <= 5)
                                    class="bg-danger text-white"
                                @endif > {{ Carbon::parse($employee->contracts[0]->endDate)->format('d-m-Y') }}
                            </td>
                            
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    @can('update', $employee)
                                        <a href="{{ route('editor.employee.edit', $employee) }}"><i class="bi bi-pencil-fill fs-4 text-primary mx-2"></i></a>     
                                    @endcan
                                    
                                    <a href="#"><i class="bi bi-printer fs-4 text-primary mx-2"></i></a> 
                                    
                                    @can('delete', $employee)
                                        <form action="{{ route('editor.employee.destroy', $employee) }}" method="post" 
                                            onsubmit="return  confirm('Voulez-vous vraiment supprimer cet employee ?')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"><i class="bi bi-eraser-fill fs-3 text-danger"></i></button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <div class="col text-danger">
                            Aucun employée correspond à votre recherche
                        </div>
                    @endforelse
                </tbody>
            </table>    
    </div>

 {{ $employees->links() }}
@endsection
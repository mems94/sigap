@php
/** 
 * Import class Carbon for datetime processing
*/
    use Carbon\Carbon;
    $nextClassAdvancement = '-';
    $pos = 0;

@endphp

@extends('layouts.app')

@section('title', 'SIGAP')

@section('content')
    <div class="d-flex justify-content-between my-2" >

        <div class="text-center rounded-3">
            <form action="" method="get" class= "container d-flex gap-2">
                <input class="form-control" type="text" name="lastName" id="lastName" placeholder="Entrer un nom" value="{{ $inputForSearch['lastName'] ?? '' }}">
                <input class="form-control" type="number" name="im" id="im" placeholder="Entrer un IM" value="{{ $inputForSearch['im'] ?? '' }}">
                <button>
                    <i class="bi bi-search fs-3 text-primary mx-3"></i>
                </button>
            </form>
        </div>
        
        <div>
            <a href="#" tooltip="Imprimer pour tous les employés"><i class="bi bi-printer-fill fs-1 text-primary mx-3"></i></a>
            
            @can('update', Employee::class)
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
                <tbody>
                    @forelse ($employees as $employee)
                        @php
                        /**
                         * To show employee position through the list
                        */
                            $pos = $pos + 1;
                        @endphp
                        <tr>
                            <td>{{ $pos }}</td>
                            <td> {{ $employee->lastName }}</td>
                            <td> {{ $employee->firstName }}</td>
                            <td> {{ $employee->im }}</td>
                            <td> {{ $employee->contract?->contractNumber }}</td>

                            <td> {{ Carbon::parse($employee->contract?->startDate)->format('d-m-Y') }}</td>
                            <td> {{ $employee->advancement?->class }}</td>

                            @php
                            /** 
                             * Advancement evolution rules
                             * Check for echelon below
                            */
                                if (!$employee->contract->avenant[0]->avenantNumber) {
                                    $nextClassAdvancement = Carbon::parse($employee->contract->startDate)->addYear();
                                } else {
                                    $nextClassAdvancement = Carbon::parse($employee->contract->avenant[0]->date)->addYears(3);
                                }  
                                $nextEchelonAdvancement = Carbon::parse($employee->contract?->startDate)->addYear();
                            @endphp

                            <td @if ($nextClassAdvancement->diffInDays(Carbon::now()) <= 5)
                                    class = "bg-danger text-white"
                                @endif > {{ $nextClassAdvancement->format('d-m-Y') }}
                            </td>

                            <td>{{ $employee->advancement?->echelon }} </td>

                            <td @if ($nextEchelonAdvancement->diffInDays(Carbon::now()) <= 5)
                                    class = "bg-danger text-white"
                                @endif >
                                {{ $nextEchelonAdvancement->format('d-m-Y') }}
                            </td>

                            <td @if (Carbon::parse($employee->contract->endDate)->diffInDays(Carbon::now()) <= 5)
                                    class="bg-danger text-white"
                                @endif > {{ Carbon::parse($employee->contract->endDate)->format('d-m-Y') }}
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
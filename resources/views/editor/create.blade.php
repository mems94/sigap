@extends('layouts.app')

@section('title', 'SIGAP')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md">
           <form class="vstack gap-2" action="{{ route($employee->exists ? 'editor.employee.update' : 'editor.employee.store', ['employee' => $employee]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method($employee->exists ? 'put' : 'post')
                
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-center fs-5">Informations du personnel</legend>    
                            <div>
                                @include('include_components.input', ['label' => 'Immatricule', 'name' => 'im', 'value' => $employee->im ])
                                @include('include_components.input', ['label' => 'Nom', 'name' => 'lastName', 'value' => $employee->lastName ])
                                @include('include_components.input', ['label' => 'Prenom', 'name' => 'firstName', 'value' => $employee->firstName ])
                                @include('include_components.input', ['label' => 'Adresse', 'name' => 'address', 'value' => $employee->address ])
                                @include('include_components.input', ['label' => 'Contact', 'name' => 'contact', 'value' => $employee->contact ])
                                @include('include_components.input', ['label' => 'Genre', 'name' => 'gender', 'value' => $employee->gender ])
                                @include('include_components.input', ['label' => 'Dernier diplome obtenu', 'name' => 'lastDegree', 'value' => $employee->lastDegree ])
                            </div>    
                        </fieldset>
                    </div>
                    
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-center fs-5">Etat d'avancement</legend>
                            <div>
                                @include('include_components.select', ['label' => 'Classe', 'name' => 'class', 'value' => $advancement->pluck('class'), 'options' => $classOptions])
                                @include('include_components.select', ['label' => 'Echelon', 'name' => 'echelon', 'value' => $advancement->pluck('echelon'), 'options' => $echelonOptions])
                                @include('include_components.input', ['label' => 'Indice', 'name' => 'indice', 'value' => $advancement->indice ])    
                                @include('include_components.input', ['label' => 'Categorie', 'name' => 'category', 'value' => $advancement->category ])             
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-center fs-5">Contract</legend>
                            <div>
                                @include('include_components.input', ['label' => 'Numero de contrat', 'name' => 'contractNumber', 'value' => $contract->contractNumber ])
                                @include('include_components.select', ['label' => 'Type de contrat', 'name' => 'contractType', 'value' => $contract->pluck('contractType'), 'options' => $contractOptions ])
                                @include('include_components.input', ['label' => 'Date de debut', 'name' => 'startDate', 'value' => $contract->startDate ])
                                @include('include_components.input', ['label' => 'Date de fin', 'name' => 'endDate', 'value' => $contract->endDate ])
                                @include('include_components.input', [ 'type' => 'file', 'label' => 'Projet de contrat', 'name' => 'projectContractFilePath', 'value' => $contract->projectContractFilePath ])
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-center fs-5">Avenant</legend>
                            <div>
                                @include('include_components.input', ['label' => 'Numero de l\'avenant', 'name' => 'avenantNumber', 'value' => $avenant->avenantNumber ])
                                @include('include_components.input', ['label' => 'Date de l\'avenant', 'name' => 'date', 'value' => $avenant->date ])
                                @include('include_components.input', [ 'type' => 'file', 'label' => 'Fichier d\'avenant', 'name' => 'avenantFilePath', 'value' => $employee->avenantFilePath ])
                            </div>
                        </fieldset>
                    </div>

                </div>

                <div class="form-group my-4">
                    <button class="btn btn-primary">
                        @if ($employee->exists)
                            Mettre à jour
                        @else
                            Enregistrer
                        @endif
                    </button>
                    <a href="{{ route('editor.employee.index') }}" class="btn btn-danger mx-2 px-4" >
                        Annuler
                    </a>
                </div>
           </form>
        </div>
    </div>
</div>
@endsection
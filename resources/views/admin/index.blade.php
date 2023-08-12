@extends('layouts.app')

@section('title', 'SIGAP')

@section('content')
    <div class="d-flex justify-content-end my-2" >
        <div>
            <a href="{{ route('registration') }}"><i class="bi bi-plus-circle-fill fs-1 text-primary"></i></a>
        </div>
    </div>

    <div class="row justify-content-center">
            <table class="table table-responsive table-striped text-center">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>login</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td> {{ $user->name }}</td>
                            <td> {{ $user->login }}</td>
                            <td> {{ $user->role }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    {{-- <a href="#"><i class="bi bi-pencil-fill fs-4 text-primary mx-2"></i></a>  --}}
                                    <form action="{{ route('delete_user', $user) }}" method="post" 
                                        onsubmit="return  confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"><i class="bi bi-eraser-fill fs-3 text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                    @endforeach
                </tbody>
            </table>    
    </div>
@endsection
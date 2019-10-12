@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Gente</h1>
            <form action="{{route('user.index')}}" id="searchForm" method="GET">
                @csrf
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search" class="form-control">
                    </div>
                    <div class="form-group col btn-search">
                        <input type="submit" class="btn btn-success" value="Buscar">        
                    </div>            
                </div>
            </form>
            <hr>
            @foreach($users as $user)
                <div class="profile-user">

                    <div class="col-md-4">
                        @if($user->image)
                            <div class="container-avatar-profile">
                                <img src="{{route('user.avatar',['filename'=>$user->image])}}" alt="" class="avatar">
                            </div>
                        @endif
                    </div>
    
                    <div class="user-info">
                        <h2>{{'@'.$user->nick}}</h2>
                        <h3>{{$user->name.' '.$user->surname}}</h3>
                        <p>{{' Se unió: '.\FormatTime::LongTimeFilter($user->created_at)}}</p>
                        <a href="{{route('user.profile',['id'=>$user->id])}}" class="btn btn-success">Ver Perfil</a>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    
                </div>
            @endforeach
            {{-- Paginacion --}}
            <div class="clearfix">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection

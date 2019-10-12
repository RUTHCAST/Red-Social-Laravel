@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-user">

                <div class="col-md-4">
                    @if($user->image)
                        <div class="container-avatar-profile">
                            <img src="{{route('user.avatar',['filename'=>$user->image])}}" alt="" class="avatar">
                        </div>
                    @endif
                </div>

                <div class="user-info">
                    <h1>{{'@'.$user->nick}}</h1>
                    <h2>{{$user->name.' '.$user->surname}}</h2>
                    <p>{{' Se unió: '.\FormatTime::LongTimeFilter($user->created_at)}}</p>
                
                </div>
                <div class="clearfix"></div>
                <hr>
                
            </div>

            <div class="clearfix"></div>
            @foreach($images as $image)
                @include('includes.image',['image'=>$image])
            @endforeach
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')

                <div class="card pub_imagen pub_imagen_detail">
                    <div class="card-header">

                        @if($image->user->image)
                            <div class="container-avatar">
                                <img src="{{route('user.avatar',['filename'=>$image->user->image])}}" alt="" class="avatar">
                            </div>
                        @endif
                        <div class="data-user">
                            {{$image->user->name.' '.$image->user->surname}}
                            <span class="nickName">{{' | @'.$image->user->nick}}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="img-container img-detail">
                                <img src="{{route('image.file',['filename'=>$image->image_path])}}" alt="" class="">
                        </div>

                        <div class="description">
                            <span class="nickName">{{'@'.$image->user->nick}}</span>
                            <span class="nickName">{{' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                            <p>{{$image->description}}</p>
                        </div>

                        <div class="likes">
                            <?php $user_like=false;?>
                            @foreach ($image->likes as $like)
                                @if($like->user->id == Auth::user()->id)
                                    <?php $user_like=true?>
                                @endif
                            @endforeach
                            @if($user_like)
                                <img src="{{asset('img/heart-red.png')}}" class="btn-like" data-id="{{$image->id}}" alt="">
                            @else
                                <img src="{{asset('img/heart-black.png')}}" class="btn-dislike" data-id="{{$image->id}}" alt="">
                            @endif
                            <span class="number_likes">{{count($image->likes)}}</span>
                        </div>

                         @if(Auth::user() && Auth::user()->id ==$image->user_id)   
                            <div class="action">
                                <a href="{{route('image.edit', ['id'=>$image->id])}}" class="btn btn-sm btn-primary">Actualizar</a>
                                <a href="" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">Borrar</a>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Eliminar Comentario</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            ¿Esta seguro de eliminar este comentario?
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                            <a href="{{route('image.delete', ['id'=>$image->id])}}" type="button" class="btn btn-danger">Aceptar</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            </div>
                        @endif

                        <div class="clearfix"></div>
                        <div class="comments">
                            <h2>Comentarios ({{count($image->comments)}})</h2>
                            <hr>

                                <form action="{{route('comment.save')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="image_id" value="{{$image->id}}">

                                    <p> 
                                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="" cols="30" rows="3">

                                        </textarea>
                                        @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </p>
                                    <button class="btn btn-success mb-3">Enviar</button>
                                </form>
                                @foreach($image->comments as $comment)
                                    <div class="comment">
                                        <span class="nickName">{{'@'.$comment->user->nick}}</span>
                                        <span class="nickName">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                                        <p>{{$comment->content}}
                                            <br>    
                                            @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                                <a href="{{route('comment.delete', ['id'=>$comment->id])}}" class="btn btn-danger my-2">
                                                    Eliminar    
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                    <hr>
                                @endforeach
                        </div>
                    </div> 
                </div>
        </div>
    </div>
</div>
@endsection

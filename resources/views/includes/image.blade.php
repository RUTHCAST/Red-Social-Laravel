<div class="card pub_imagen">
    <div class="card-header">

        @if($image->user->image)
            <div class="container-avatar">
                <img src="{{route('user.avatar',['filename'=>$image->user->image])}}" alt="" class="avatar">
            </div>
        @endif
        <div class="data-user">
            <a href="{{route('user.profile',['id'=>$image->user->id])}}">
                {{$image->user->name.' '.$image->user->surname}}
                <span class="nickName">{{' | @'.$image->user->nick}}</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="img-container">
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

        <div class="comments">
            <a href="{{route('image.detail',['id'=>$image->id])}}" class="btn btn-warning btn-sm btn-comments">Comentarios ({{count($image->comments)}})</a>
        </div>

    </div> 
</div>

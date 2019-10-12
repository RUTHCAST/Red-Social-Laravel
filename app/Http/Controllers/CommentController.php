<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\comment;

class CommentController extends Controller
{
    // Restringir el acceso a este controlador a usuarios identificados
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){

        $validate=$this->validate($request,[
            'image_id'=> 'required|integer',
            'content'=> 'required|string',
        ]);
        $user=\Auth::user()->id;
        $image_id=$request->input('image_id');
        $content=$request->input('content');
        
        $comment = new comment();

        $comment->user_id=$user;
        $comment->image_id=$image_id;
        $comment->content=$content;

        $comment->save();

        return redirect()->route('image.detail',['id'=>$image_id])
                        ->with('message','Comentario agregado exitosamente');



    }

    public function delete($id){
        // Conseguir datos del usuario logueado
        $user=\Auth::user();

        // Conseguir objeto del comentario
        $comment=Comment::find($id);

        // Comprobar si soy el dueño de la publicacion o del comentario
        if($user && $comment->user_id == $user->id || $comment->image->user_id == $user->id){

            $comment->delete();
            return redirect()->route('image.detail',['id'=>$comment->image->id])
                            ->with('message', 'Comentario Eliminado Correctamente');
        }else{
            return redirect()->route('image.detail',['id'=>$comment->image->id])
                            ->with('message', 'El comentario ho ha podido ser eliminado');
        }

    }
}

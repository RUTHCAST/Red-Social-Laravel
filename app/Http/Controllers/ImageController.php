<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\like;
use App\User;
use App\comment;

class ImageController extends Controller
{
    // Restringir el acceso a este controlador a usuarios identificados
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){
        
        // Vallidation
        $validate=$this->validate($request,[
            'description'=> 'required|',
            'image_path'=> 'required|image'
        ]);
        
        // Recogiendo los datos
        $image_path=$request->file('image_path');
        $description=$request->input('description');

        // Asignar valores al objeto
        $user=\Auth::user();
        $image = new Image();
        $image->image_path= null;
        $image->user_id = $user->id;
        $image->description= $description;

        // Subir Ficheros
        if($image_path){
            $image_path_name=time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            // Seteo el nombre de la imagen en el objeto
            $image->image_path=$image_path_name;
        }

        // Guardar el objeto
        $image->save();

        return redirect()->route('home')
                         ->with(['message'=>'La imagen fue subida correctamente']);
        
    }

    public function getImage($filename){
        $file=Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id){
        $image=Image::find($id);

        return view('image.detail',['image'=>$image]);
    }

    public function delete($id){
        $user=Auth::user();
        $image=Image::find($id);
        $comments=Comment::where('image_id', $id)->get();
        $likes=Like::where('image_id', $id)->get();

        if($image && $image && $image->user_id = $user->id){

            // Eliminar los comentarios
            if($comments && count($comments)>=1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }

            // Eliminar los likes
            if($likes && count($likes)>=1){
                foreach($likes as $like){
                    $like->delete();
                }
            }

            // Eliminar los archivos de imagenes del directorio
            Storage::disk('images')->delete($image->image_path);

            // Eliminar la imagen
            $image->delete();

            $message=array(
                'message'=>'La imagen se ha borrado correctamente'
            );

            return redirect()->route('home')->with($message);
        }else{
            $message=array(
                'message'=>'La imagen no se ha borrado'
            );
        }

    }

    public function edit($image_id){
        $user=Auth::user();
        $image=Image::find($image_id);

        if($user && $image && $image->user->id ==$user->id){
            return view('image.edit', [
                'image'=> $image
            ]);
        }else{
            return redirect()->route('home');
        }

    }

    public function update(Request $request){
        $validate=$this->validate($request,[
            'description'=> 'required',
            'image_path'=> 'image'
        ]);

        $image_id=$request->input('image_id');
        $description=$request->input('description');
        $image_path=$request->file('image_path');

        // Conseguir objeto image de la bd
        $image=image::find($image_id);
        $image->description =$description;

        // Subir el fichero
        if($image_path){
            $image_path_name=time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            // Seteo el nombre de la imagen en el objeto
            $image->image_path=$image_path_name;
        }
        // Actualizar el registro
        $image->update();

        return redirect()->route('image.detail',['id'=>$image->id])->with(['message'=> 'Imagen actualizada con exito']);
    }
}

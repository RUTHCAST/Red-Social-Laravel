<?php

namespace App\Http\Controllers;

use App\image;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($search=null){
        if(!empty($search)){
            $users=User::where('nick','LIKE','%'.$search.'%')
                         ->orWhere('name','LIKE','%'.$search.'%')
                         ->orWhere('surname','LIKE','%'.$search.'%')
                         ->orderBy('id','desc')
                         ->paginate(5);
        }
        else{
            $users=User::orderBy('id','desc')->paginate(5);
        }
        return view('users.index',[
            'users'=>$users]);
    }

    public function config(){
        return view('users.config');
    }

    public function update(Request $request){
        // Conseguir usuario identificado
        $user=\Auth::user();
        $id=$user->id;

        // Validacion del formulario
        $validate = $this->validate($request, [
            
            'name' => 'required | string | max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id

        ]);

        // Recoger Datos del Formulario
        
        $name=$request->input('name');
        $surname=$request->input('surname');
        $nick=$request->input('nick');
        $email=$request->input('email');
        
        // Asignar nuevos valores al objeto de usuario
        $user->name= $name;
        $user->surname=$surname;
        $user->nick=$nick;
        $user->email=$email;

        // Subir la imagen
        $imagen_path=$request->file('image_file');
        if($imagen_path){

            // Poner nombre unico
            $image_path_name=time().$imagen_path->getClientOriginalName();

            // Guardarla en la carpeta app/users
            Storage::disk('users')->put($image_path_name, File::get($imagen_path));

            // Seteo el nombre de la imagen en el objeto
            $user->image=$image_path_name;
        }


        // Ejecutar consulta y cambios en la base de datos
        $user->update();

        // Redireccionar
        return redirect()->route('config')
                        ->with(['message'=>'Usuario actualizado correctamente']);

    }

    public function getImagen($filename){
        $file=Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    public function profile($id){
        $user=User::find($id);
   
        $images=Image::where('user_id', $id)
                     ->orderBy('id','desc')->paginate(5);

        return view('users.profile', [
            'user'=>$user,
            'images'=>$images
        ]);
    }
}

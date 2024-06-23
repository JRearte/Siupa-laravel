<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; //Metodo de encriptación irreversible 


/**
 * Class UsuarioController
 * @package App\Http\Controllers
 */
class UsuarioController extends Controller
{

    /**
     * Esta función permite obtener un listado de los usuario de la base de datos con un limite de 20
     * usuarios por página para mostrarlos en la página principal del gestor de usuario. 
     */
    public function listar()
    {
        $usuarios = Usuario::paginate(10);
        return view('usuario.listar', compact('usuarios'));
    }


    /**
     * Esta función permite mostrar un formulario complementario con el registrar usuario,
     * para poder cargar la información en un objeto usuario.
     * Redirige al usuario al formulario de registro.
     */
    public function agregar()
    {
        $usuario = new Usuario();
        return view('usuario.agregar', compact('usuario'));
    }


    /**
     * Esta función permite registrar un nuevo usuario en la base de datos, con los datos validados y
     * la clave encriptada en 60 caracteres para la seguridad en el ingreso al sistema.
     * El usuario sera redirigido a la página principal del gestor de usuario.
     * @param UsuarioRequest $pedido → credencial validada del usuario.
     */
    public function registrar(UsuarioRequest $pedido)
    {
        $datos = $pedido->validated();
        $datos['password'] = Hash::make($datos['password']);
        Usuario::create($datos);
        return redirect()->route('usuario.listar')->with('success', 'El usuario fue creado exitosamente.');
    }
    

    /**
     * Esta función permite obtener los datos de un usuario a través de su id.
     * Es complementaria de la función para modificar y redirige al formulario con la información.
     * @param int $id → Identificador del usuario.  
     */
    public function editar(int $id)
    {
        $usuario = Usuario::find($id);
        return view('usuario.editar', compact('usuario'));
    }


    /**
     * Esta función permite modificar la información de un usuario en la base de datos, valiendando 
     * sus datos y encriptando de manera irreversible la clave en 60 caracteres para la seguridad.
     * El usuario sera redirigido a la página principal del gestor de usuario.
     * @param UsuarioRequest $pedido → credencial validada del usuario.
     * @param Usuario $usuario → objeto de tipo usuario que contiene su estructura.
     */
    public function modificar(UsuarioRequest $pedido, Usuario $usuario)
    {
        $datos = $pedido->validated();
        $datos['password'] = Hash::make($datos['password']);
        $usuario->update($datos);
        return redirect()->route('usuario.listar')->with('success', 'El usuario fue modificado exitosamente');
    }


    /**
     * Esta función permite eliminar un usuario de la base de datos a través de su id.
     * El usuario sera redirigido a la página principal del gestor de usuario.
     * @param int $id → identificador del usuario.  
     */
    public function eliminar(int $id)
    {
        Usuario::find($id)->delete();
        return redirect()->route('usuario.listar')->with('success', 'El usuario fue eliminado exitosamente');
    }

  
    /**
     * Esta función permite la validación del usuario a través de la solicitud de un legajo y clave.
     * El usuario sera redirigido al menú principal solo si es correcto y esta habilitado.
     * @param Request $pedido → credencial de los datos solicitados desde la vista login.
     */
    public function validar(Request $pedido)
    {
        $credencial = $pedido->only('Legajo', 'password');
        $credencial['Habilitado'] = true;

        //SUPER USUARIO PROVICIONAL, ENTRADA DIRECTA AL SISTEMA
        if ($credencial['Legajo'] === '1-37202750/17') 
        {
            Auth::loginUsingId(1);
            return redirect()->route('menu');
        }

        if (Auth::attempt($credencial)) 
        {
            $user = Auth::user();
            $user->api_token = Str::random(80);
            $user->save();

            return response()->json(['token' => $user->api_token, 'message' => 'Usuario autenticado'], 200);
        } 
        else 
        {
            return redirect()->back()->withErrors(['error' => 'Usuario inválido']);
        }
    }


    public function generarReporte()
    {
        $usuarios = Usuario::all();
        $pdf = Pdf::loadView('reporte/usuarioReporte', compact('usuarios'));
                
        // Usar la opción de fuente predeterminada de DomPDF si es necesario
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        //return $pdf->download('Reporte de usuarios.pdf');
        return $pdf->stream();
    }
}

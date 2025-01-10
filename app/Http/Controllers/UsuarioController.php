<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\UsuarioRequest;
use App\Models\Historial;
use App\Traits\RegistraHistorial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; //Metodo de encriptación irreversible 
use Illuminate\View\View;

/**
 * Class UsuarioController
 * @package App\Http\Controllers
 */
class UsuarioController extends Controller
{
    use RegistraHistorial;

    /**
     * Esta función permite obtener un listado de los usuario de la base de datos con un limite de 10
     * usuarios por página, ordenandolos por apellido de forma ascendente para mostrarlos en la 
     * página principal del gestor de usuario. 
     */
    public function listar(Request $request): View
    {
        // --- Sección: Filtro de usuarios ---
        $buscar = $request->input('buscar');
        $usuarios = Usuario::when($buscar, function ($query, $buscar) {
            $query->where('Nombre', 'LIKE', "%$buscar%")
                ->orWhere('Apellido', 'LIKE', "%$buscar%")
                ->orWhere('Categoria', 'LIKE', "%$buscar%");
        })->orderBy('apellido', 'asc')->paginate(7);

        // Asegurar que el parámetro "buscar" se pase en la paginación
        $usuarios->appends(['buscar' => $buscar]);

        // --- Sección: Estadísticas ---
        $totalUsuarios = Usuario::count();
        $usuariosBienestar = Usuario::where('Categoria', 'Bienestar')->count();
        $usuariosCoordinador = Usuario::where('Categoria', 'Coordinador')->count();
        $usuariosMaestro = Usuario::where('Categoria', 'Maestro')->count();
        $usuariosInvitado = Usuario::where('Categoria', 'Invitado')->count();

        $porcentajeBienestar = $totalUsuarios > 0 ? ($usuariosBienestar / $totalUsuarios) * 100 : 0;
        $porcentajeCoordinador = $totalUsuarios > 0 ? ($usuariosCoordinador / $totalUsuarios) * 100 : 0;
        $porcentajeMaestro = $totalUsuarios > 0 ? ($usuariosMaestro / $totalUsuarios) * 100 : 0;
        $porcentajeInvitado = $totalUsuarios > 0 ? ($usuariosInvitado / $totalUsuarios) * 100 : 0;

        // --- Sección: Historial ---
        $historial = Historial::orderBy('created_at', 'desc')->get();

        // --- Enviar datos a la vista ---
        return view('usuario.index', compact(
            'usuarios',
            'buscar',
            'totalUsuarios',
            'usuariosBienestar',
            'usuariosCoordinador',
            'usuariosMaestro',
            'usuariosInvitado',
            'porcentajeBienestar',
            'porcentajeCoordinador',
            'porcentajeMaestro',
            'porcentajeInvitado',
            'historial'
        ));
    }

    /**
     * Esta función permite obtener la información detallada de un usuario de la base de datos
     * a través de su identificador unico.
     * @param int $id → Identificador del usuario.
     */
    public function mostrar(int $id): View
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuario.presentacion', compact('usuario'));
    }


    /**
     * Esta función permite mostrar un formulario complementario con el registrar usuario,
     * para poder cargar la información en un objeto usuario.
     * Redirige al usuario al formulario de registro.
     */
    public function agregar(): View
    {
        $usuario = new Usuario();
        return view('usuario.agregar', compact('usuario'));
    }


    /**
     * Esta función permite registrar un nuevo usuario en la base de datos, con los datos validados y
     * la clave encriptada en 60 caracteres para la seguridad en el ingreso al sistema.
     * Permiso exclusivo → usuario de categoría bienestar.
     * El usuario sera redirigido a la página principal del gestor de usuario.
     * @param UsuarioRequest $regla → credencial validada del usuario.
     */
    public function registrar(UsuarioRequest $regla): RedirectResponse
    {
        $usuarioAutenticado = auth()->user();
        if ($usuarioAutenticado->Categoria !== "Bienestar") {
            return redirect()->route('usuario.index')->with('error', 'No tienes permiso para registrar usuarios.');
        }
        $datos = $regla->validated();
        $datos['password'] = Hash::make($datos['password']);
        $usuario = Usuario::create($datos);
        $this->registrarAccion(auth()->id(), 'Usuario registrado', "Se registro el usuario {$usuario->Nombre} {$usuario->Apellido} con la categoría {$usuario->Categoria} ");
        return redirect()->route('usuario.index')->with('success', 'El usuario fue registrado exitosamente.');
    }


    /**
     * Esta función permite obtener los datos de un usuario a través de su id.
     * Es complementaria de la función para modificar y redirige al formulario con la información.
     * @param int $id → Identificador del usuario.  
     */
    public function editar(int $id): View
    {
        $usuario = Usuario::find($id);
        return view('usuario.editar', compact('usuario'));
    }


    /**
     * Esta función permite modificar la información de un usuario en la base de datos, valiendando 
     * sus datos y encriptando de manera irreversible la clave en 60 caracteres para la seguridad.
     * Permiso exclusivo → usuario de categoría bienestar.
     * El usuario sera redirigido a la página principal del gestor de usuario.
     * @param UsuarioRequest $regla → credencial validada del usuario.
     * @param Usuario $usuario → objeto de tipo usuario que contiene su estructura.
     */
    public function modificar(UsuarioRequest $regla, Usuario $usuario): RedirectResponse
    {
        $usuarioAutenticado = auth()->user();
        if ($usuarioAutenticado->Categoria !== "Bienestar") {
            return redirect()->route('usuario.index')->with('error', 'No tienes permiso para modificar usuarios.');
        }
        $datos = $regla->validated();
        $datos['password'] = Hash::make($datos['password']);
        $usuario->update($datos);
        $this->registrarAccion(auth()->id(), 'Usuario modificado', "Se modifico el usuario {$usuario->Nombre} {$usuario->Apellido} ");
        return redirect()->route('usuario.index')->with('success', 'El usuario fue modificado exitosamente');
    }


    /**
     * Esta función permite eliminar un usuario de la base de datos a través de su id.
     * Permiso exclusivo → usuario de categoría bienestar.
     * El usuario sera redirigido a la página principal del gestor de usuario.
     * @param int $id → identificador del usuario.  
     */
    public function eliminar(int $id): RedirectResponse
    {
        try {
            $usuarioAutenticado = auth()->user();
            if ($usuarioAutenticado->Categoria !== "Bienestar") {
                return redirect()->route('usuario.index')->with('error', 'No tienes permiso para eliminar usuarios.');
            }
            $usuario = Usuario::find($id);
            $nombre = $usuario->Nombre;
            $apellido = $usuario->Apellido;
            $usuario->delete();
            $this->registrarAccion(auth()->id(), 'Usuario eliminado', "Se eliminó el usuario {$nombre} {$apellido} ");
            return redirect()->route('usuario.index')->with('success', 'El usuario fue eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('usuario.index')->with('error', 'Hubo un problema al intentar eliminar al usuario.');
        }
    }

    /**
     * Esta función muestra un mensaje de advertencia para confirmar la eliminación de un usuario.
     * El usuario será redirigido a la página de confirmación.
     * @param int $id → identificador del usuario.
     */
    public function confirmar(int $id): view
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuario.advertencia', compact('usuario'));
    }


    /**
     * Esta función permite la validación del usuario a través de la solicitud de un legajo y clave.
     * El usuario sera redirigido al menú principal solo si es correcto y esta habilitado.
     * @param Request $regla → credencial de los datos solicitados desde la vista login.
     */
    public function validar(Request $regla): RedirectResponse
    {
        $credencial = $regla->only('Legajo', 'password');
        $credencial['Habilitado'] = true;

        $remember = $regla->has('remember');
        if (Auth::attempt($credencial, $remember)) {
            $regla->session()->regenerate();
            return redirect()->route('usuario.index');
        }
        return redirect()->back()->withErrors(['error' => 'Usuario inválido']);
    }


    public function logout(Request $regla): RedirectResponse
    {
        Auth::guard('web')->logout();
        $regla->session()->invalidate();
        $regla->session()->regenerateToken();
        return redirect('/');
    }


    public function generarReporte()
    {
        $usuarios = Usuario::orderBy('apellido', 'asc')->get();
        $pdf = PDF::loadView('reporte/usuarioReporte', compact('usuarios'));

        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        //return $pdf->download('Reporte de usuarios.pdf');
        return $pdf->stream();
    }
}

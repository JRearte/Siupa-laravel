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
     * Este método:
     * → Obtiene un listado paginado de 7 usuarios ordenados por apellido en orden ascendente.
     * → Brinda un filtro por: nombre, apellido y categoría.
     * → Proporciona datos estadísticos de los usuarios según su categoría.
     * → Recupera el historial de acciones de los usuarios, ordenado por fecha en orden descendente.
     * 
     * @param Request $regla → Contiene el término de búsqueda opcional.
     * @return View → Retorna las variables a la vista usuario.index.
     */
    public function listar(Request $regla): View
    {
        // ==================== Filtro de usuarios ====================
        $buscar = $regla->input('buscar');
        $usuarios = Usuario::when($buscar, function ($query, $buscar) {
            $query->where('Nombre', 'LIKE', "%$buscar%")
                ->orWhere('Apellido', 'LIKE', "%$buscar%")
                ->orWhere('Categoria', 'LIKE', "%$buscar%");
        })->orderBy('apellido', 'asc')->paginate(7);

        $usuarios->appends(['buscar' => $buscar]);

        // ==================== Estadísticas ====================
        $totalUsuarios = Usuario::count();
        $usuariosBienestar = Usuario::where('Categoria', 'Bienestar')->count();
        $usuariosCoordinador = Usuario::where('Categoria', 'Coordinador')->count();
        $usuariosMaestro = Usuario::where('Categoria', 'Maestro')->count();
        $usuariosInvitado = Usuario::where('Categoria', 'Invitado')->count();

        $porcentajeBienestar = $totalUsuarios > 0 ? ($usuariosBienestar / $totalUsuarios) * 100 : 0;
        $porcentajeCoordinador = $totalUsuarios > 0 ? ($usuariosCoordinador / $totalUsuarios) * 100 : 0;
        $porcentajeMaestro = $totalUsuarios > 0 ? ($usuariosMaestro / $totalUsuarios) * 100 : 0;
        $porcentajeInvitado = $totalUsuarios > 0 ? ($usuariosInvitado / $totalUsuarios) * 100 : 0;

        // ==================== Historial ====================
        $historial = Historial::orderBy('created_at', 'desc')->get();

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
     * Este método:
     * → Recupera la información detallada de un usuario por su identificador único.
     * 
     * @param int $id → Identificador único del usuario.
     * @return View → Retorna la vista usuario.presentacion con los datos del usuario.
     */
    public function presentar(int $id): View
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuario.presentacion', compact('usuario'));
    }


    /**
     * Este método:
     * → Muestra el formulario para registrar un nuevo usuario.
     * → Prepara un objeto usuario vacío para su carga inicial.
     * 
     * @return View → Retorna la vista usuario.agregar con el objeto usuario.
     */
    public function formularioRegistrar(): View
    {
        $usuario = new Usuario();
        return view('usuario.agregar', compact('usuario'));
    }


    /**
     * Este método:
     * → Registra un nuevo usuario en la base de datos con datos validados y contraseña encriptada.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param UsuarioRequest $regla → Datos validados del usuario a registrar.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
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
     * Este método:
     * → Recupera los datos de un usuario por su identificador único.
     * → Redirige al formulario de edición con la información del usuario cargada.
     * 
     * @param int $id → Identificador único del usuario.
     * @return View → Retorna la vista usuario.editar con los datos del usuario.
     */
    public function formularioModificar(int $id): View
    {
        $usuario = Usuario::find($id);
        return view('usuario.editar', compact('usuario'));
    }


    /**
     * Este método:
     * → Modifica la información de un usuario en la base de datos con datos validados.
     * → Encripta de manera irreversible la contraseña para mayor seguridad.
     * → Solo permite la modificación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param UsuarioRequest $regla → Datos validados del usuario a modificar.
     * @param Usuario $usuario → Objeto usuario con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
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
     * Este método:
     * → Muestra un mensaje de advertencia para confirmar la eliminación de un usuario.
     * → Redirige al usuario a la página de confirmación de eliminación.
     * 
     * @param int $id → Identificador único del usuario a eliminar.
     * @return View → Retorna la vista usuario.advertencia con los datos del usuario.
     */
    public function advertirEliminacion(int $id): View
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuario.advertencia', compact('usuario'));
    }

    /**
     * Este método:
     * → Elimina un usuario de la base de datos por su identificador único.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción de eliminación en el historial.
     * 
     * @param int $id → Identificador único del usuario a eliminar.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
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
     * Este método:
     * → Valida al usuario mediante el legajo y la clave proporcionados.
     * → Redirige al menú principal solo si las credenciales son correctas y el usuario está habilitado.
     * 
     * @param Request $regla → Credenciales de inicio de sesión solicitadas desde la vista login.
     * @return RedirectResponse → Redirige al menú principal o muestra un error si las credenciales son incorrectas.
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


    /**
     * Este método:
     * → Cierra la sesión del usuario y invalida la sesión actual.
     * → Regenera el token de sesión para mayor seguridad.
     * → Redirige al usuario a la página de inicio.
     * 
     * @param Request $regla → Solicitud que contiene los datos necesarios para cerrar la sesión.
     * @return RedirectResponse → Redirige al inicio después de cerrar sesión.
     */
    public function logout(Request $regla): RedirectResponse
    {
        Auth::guard('web')->logout();
        $regla->session()->invalidate();
        $regla->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Este método:
     * → Genera un reporte en formato PDF con un listado de usuarios ordenados por apellido.
     * → Establece el tamaño de papel A4 en orientación vertical para el reporte.
     * → Muestra el reporte PDF directamente en el navegador.
     * 
     * @return PDF → Retorna el PDF generado para ser mostrado o descargado.
     */
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

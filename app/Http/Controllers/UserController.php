<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    // ============================================
    // ✅ REGISTRO DE USUARIOS
    // ============================================
    public function register(Request $request)
    {
        // Validamos los campos del formulario de registro
        $request->validate([
            'name' => 'required|string',     // nombre obligatorio
            'email' => 'required|string',    // email obligatorio
            'password' => 'required|string', // contraseña obligatoria
        ]);

        // Creamos un nuevo usuario con los datos recibidos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // ❗Sin hash por simplicidad (idealmente se encripta)
        ]);

        // Redirigimos al login una vez registrado
        return redirect()->route('login');
    }

    // ============================================
    // ✅ INICIO DE SESIÓN DEL USUARIO
    // Relacionado con el criterio 04_01
    // ya que aquí se registra el último acceso anterior
    // ============================================
    public function login(Request $request)
    {
        // Buscamos el usuario por nombre (username)
        $user = User::where('name', $request->name)->first();

        // Si existe y la contraseña coincide:
        if ($user && $user->password === $request->password) {

            // 🔥 Guardamos en la sesión la última fecha de acceso anterior
            // Esto se usará para saber qué películas nuevas hay desde la última vez
            Session::put('last_login_before', $user->last_login);

            // ✅ Actualizamos el campo last_login a la fecha y hora actual
            $user->last_login = now();
            $user->save();

            // Guardamos datos de usuario en la sesión
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);

            // Redirigimos al inicio (home Vue)
            return redirect('/');
        } 
        // ❌ Si los datos son incorrectos, mostramos error
        else {
            return redirect()->back()
                ->with('error', 'Invalid credentials please try again or create an account 1st');
        }
    }
}

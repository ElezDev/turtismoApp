<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    // public function register(Request $request)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'idTipoIdentificacion' => 'required',
    //             'identificacion' => 'required|unique:persona',
    //             'nombre1' => 'required',
    //             'apellido1' => 'required',
    //             'email' => 'required|email|unique:usuario',
    //             'contrasena' => 'required',
    //             'celular' => 'required',
    //             'device_token' => 'string'
    //         ]);

    //         DB::beginTransaction();

    //         $persona = new Person();
    //         $persona->idTipoIdentificacion = $validatedData['idTipoIdentificacion'];
    //         $persona->identificacion = $validatedData['identificacion'];
    //         $persona->nombre1 = $validatedData['nombre1'];
    //         $persona->apellido1 = $validatedData['apellido1'];
    //         $persona->email = $validatedData['email'];
    //         $persona->celular = $validatedData['celular'];
    //         $persona->rutaFoto = $this->storeLogoPersona($request);
    //         $persona->save();

    //         $usuario = new User();
    //         $usuario->email = $validatedData['email'];
    //         $usuario->device_token = $validatedData['device_token'];
    //         $usuario->contrasena = bcrypt($validatedData['contrasena']);
    //         $usuario->idpersona = $persona->id;
    //         $usuario->save();

    //         DB::commit();
    //         $token = JWTAuth::fromUser($usuario);

    //         return response()->json(compact('token'), 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['errors' => 'Se encontraron errores de validación en la solicitud.'], 422);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'Error al procesar la solicitud'], 500);
    //     }
    // }


    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', $validatedData['email'])->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return response()->json([
                    'error' => 'Credenciales inválidas'
                ], 400);
            }

            $token = JWTAuth::fromUser($user);
            $roles = $user->getRoleNames();
            return response()->json([
                'token' => $token,
                'roles' => $roles
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }








    // public function logout()
    // {
    //     $user = auth()->user();

    //     if ($user && $user->device_token) {
    //         $user->device_token = null;
    //         $user->save();
    //     }

    //     auth()->logout();

    //     return response()->json(['message' => 'Sesión cerrada exitosamente']);
    // }



    // public function userData()
    // {
    //     if (auth()->check()) {
    //         $user = auth()->user()->load('persona');

    //         return response()->json(["userData" => $user], 200);
    //     } else {
    //         return response()->json(["message" => "No autorizado"], 401);
    //     }
    // }


    // private function storeLogoPersona(Request $request, $default = true)
    // {
    //     $rutaFoto = null;

    //     if ($default) {
    //         $rutaFoto = Person::RUTA_FOTO_DEFAULT;
    //     }
    //     if ($request->hasFile('rutaFotoFile')) {
    //         $rutaFoto =
    //             '/storage/' .
    //             $request
    //             ->file('rutaFotoFile')
    //             ->store(Person::RUTA_FOTO, ['disk' => 'public']);
    //     }
    //     return $rutaFoto;
    // }


    // public function updateProfileMovil(Request $request)
    // {
    //     try {
    //         $user = auth()->user()->load('persona');
    //         $persona = $user->persona;

    //         $request->validate([
    //             'nombre1' => 'nullable|string|max:255',
    //             'nombre2' => 'nullable|string|max:255',
    //             'apellido1' => 'nullable|string|max:255',
    //             'apellido2' => 'nullable|string|max:255',
    //             'celular' => 'nullable|string',
    //             'rutaFoto' => 'nullable|string|max:500',
    //         ]);

    //         if ($request->has('nombre1')) {
    //             $persona->nombre1 = $request->input('nombre1');
    //         }

    //         if ($request->has('nombre2')) {
    //             $persona->nombre2 = $request->input('nombre2');
    //         }

    //         if ($request->has('apellido1')) {
    //             $persona->apellido1 = $request->input('apellido1');
    //         }

    //         if ($request->has('apellido2')) {
    //             $persona->apellido2 = $request->input('apellido2');
    //         }

    //         if ($request->has('celular')) {
    //             $persona->celular = $request->input('celular');
    //         }

    //         if ($request->has('rutaFotoFile')) {
    //             $persona->rutaFoto = $this->storeLogoPersona($request);
    //         }

    //         $persona->save();

    //         return response()->json(['message' => 'Perfil actualizado con éxito']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()], 500);
    //     }
    // }
}

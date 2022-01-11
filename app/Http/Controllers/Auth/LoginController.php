<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\PosService;
use App\Services\PosAuthenticationService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * El servicio para realizar acciones de autenticación
     *
     * @var App\Services\PosAuthenticationService
     */
    protected $posAuthenticationService;


    /**
     * Cree una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct(PosAuthenticationService $posAuthenticationService, posService $posService)
    {
        $this->middleware('guest')->except('logout');

        $this->posAuthenticationService = $posAuthenticationService;
      
        parent::__construct($posService);
    }

    /**
     * Muestre el formulario de inicio de sesión de la aplicación.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $authorizationUrl = $this->posAuthenticationService->resolveAuthorizationUrl();

        return view('auth.login')->with(['authorizationUrl' => $authorizationUrl]);
    }

    /**
     * Recibe el resultado de la autorización de la API
     * @return \Illuminate\Http\Response
     */
    public function authorization(Request $request)
    {

        if ($request->has('code')) {
            $tokenData = $this->posAuthenticationService->getCodeToken($request->code);

            $userData = $this->posService->getUserInformation();

            $user = $this->registerOrUpdateUser($userData, $tokenData);

            $this->loginUser($user);

            return redirect()->intended('pos');
        }

        return redirect()->route('login')->withErrors(['You caneceled the authorization process']);
    }

    /**
     * Manejar una solicitud de inicio de sesión a la aplicación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        
        $this->validateLogin($request);

        // Si la clase está usando el rasgo ThrottlesLogins, podemos acelerar automáticamente
         // los intentos de inicio de sesión para esta aplicación. Teclearemos esto por el nombre de usuario y
         // la dirección IP del cliente que realiza estas solicitudes en esta aplicación.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try {
            $tokenData = $this->posAuthenticationService->getPasswordToken($request->email, $request->password);

            $userData = $this->posService->getUserInformation();

            $user = $this->registerOrUpdateUser($userData, $tokenData);

            $this->loginUser($user, $request->has('remember'));

            return redirect()->intended('pos');
        } catch (ClientException $e) {
            $message = $e->getResponse()->getBody();
            if (Str::contains($message, 'invalid_credentials')) {
                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponse($request);
            }

            throw $e;
        }
    }

    /**
     * Creates or updates a user from the API
     * @param  stdClass $userData
     * @param  stdClass $tokenData
     * @return App\User
     */
    public function registerOrUpdateUser($userData, $tokenData)
    {

        return User::updateOrCreate(
            [
                'service_id' => $userData->identificador,
            ],
            [
                'grant_type' => $tokenData->grant_type,
                'access_token' => $tokenData->access_token,
                'refresh_token' => $tokenData->refresh_token,
                'token_expires_at' => $tokenData->token_expires_at,
            ]
        );
    }

    /**
     * Authenticates a user on the CLient
     * @param  App\User    $user
     * @param  boolean $remember
     * @return void
     */
    public function loginUser(User $user, $remember = true)
    {
        
        Auth::login($user, $remember);

        session()->regenerate();
    }
    
}

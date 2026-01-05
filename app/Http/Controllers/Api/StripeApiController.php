<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Webhook;
use Carbon\Carbon;

class StripeApiController extends Controller
{
    /**
     * Crear sesión de checkout de Stripe
     * POST /api/stripe/create-checkout-session
     */
    public function createCheckoutSession(Request $request)
    {
        try {
            Log::info('Iniciando creación de sesión de checkout');
            
            $user = Auth::user();
            
            if (!$user) {
                Log::error('Usuario no autenticado');
                return response()->json([
                    'success' => false,
                    'session_id' => null,
                    'session_url' => null,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            Log::info('Usuario autenticado: ' . $user->email);

            $stripeSecret = config('services.stripe.secret');
            
            if (!$stripeSecret) {
                Log::error('STRIPE_SECRET no configurado');
                return response()->json([
                    'success' => false,
                    'session_id' => null,
                    'session_url' => null,
                    'message' => 'Configuración de Stripe incompleta'
                ], 500);
            }

            Stripe::setApiKey($stripeSecret);
            Log::info('API Key de Stripe configurada');

            // Crear sesión de Stripe Checkout
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Suscripción mensual Netflix',
                            'description' => 'Acceso completo por 30 días',
                        ],
                        'unit_amount' => 990, // $9.90 USD
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                // URLs para Android deep linking
                'success_url' => 'netflixapp://stripe/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'netflixapp://stripe/cancel',
                'client_reference_id' => (string)$user->id,
                'customer_email' => $user->email,
            ]);

            Log::info('Sesión de Stripe creada: ' . $session->id);

            return response()->json([
                'success' => true,
                'session_id' => $session->id,
                'session_url' => $session->url,
                'message' => null
            ], 200);

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Error de Stripe InvalidRequest: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'session_id' => null,
                'session_url' => null,
                'message' => 'Error en la configuración de Stripe: ' . $e->getMessage()
            ], 400);
            
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Error de API de Stripe: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'session_id' => null,
                'session_url' => null,
                'message' => 'Error al comunicarse con Stripe: ' . $e->getMessage()
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Error general al crear sesión de Stripe: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'session_id' => null,
                'session_url' => null,
                'message' => 'Error al crear sesión de pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estado de suscripción del usuario
     * GET /api/subscription/status
     */
    public function getSubscriptionStatus(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $isActive = false;
            $expiresAt = null;
            $daysRemaining = 0;

            if ($user->suscripcion_activa && $user->suscripcion_expira) {
                $expirationDate = Carbon::parse($user->suscripcion_expira);
                $now = Carbon::now();
                
                if ($expirationDate->isFuture()) {
                    $isActive = true;
                    $expiresAt = $expirationDate->toDateTimeString();
                    $daysRemaining = $now->diffInDays($expirationDate);
                } else {
                    // La suscripción ha expirado, actualizarla
                    $user->suscripcion_activa = false;
                    $user->save();
                }
            }

            return response()->json([
                'success' => true,
                'active' => $isActive,
                'expires_at' => $expiresAt,
                'days_remaining' => $daysRemaining,
                'plan' => 'monthly',
                'message' => null
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener estado de suscripción: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estado de suscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar si la suscripción es válida
     * POST /api/subscription/verify
     */
    public function verifySubscription(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado',
                    'valid' => false
                ], 401);
            }

            $isValid = false;
            $daysRemaining = 0;

            if ($user->suscripcion_activa && $user->suscripcion_expira) {
                $expirationDate = Carbon::parse($user->suscripcion_expira);
                $now = Carbon::now();
                
                if ($expirationDate->isFuture()) {
                    $isValid = true;
                    $daysRemaining = $now->diffInDays($expirationDate);
                } else {
                    // Desactivar suscripción expirada
                    $user->suscripcion_activa = false;
                    $user->save();
                }
            }

            return response()->json([
                'success' => true,
                'valid' => $isValid,
                'days_remaining' => $daysRemaining,
                'message' => null
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al verificar suscripción: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar suscripción',
                'valid' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activar suscripción después de un pago exitoso
     * POST /api/subscription/activate
     * 
     * Este endpoint es llamado desde Android después de completar el pago
     * para confirmar y activar la suscripción del usuario
     */
    public function activateSubscriptionAfterPayment(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'activated' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $sessionId = $request->input('session_id');
            
            if (!$sessionId) {
                return response()->json([
                    'success' => false,
                    'activated' => false,
                    'message' => 'Session ID es requerido'
                ], 400);
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Recuperar la sesión de Stripe para verificar el pago
            $session = StripeSession::retrieve($sessionId);
            
            // Verificar que el pago fue exitoso
            if ($session->payment_status !== 'paid') {
                return response()->json([
                    'success' => false,
                    'activated' => false,
                    'message' => 'El pago no ha sido completado',
                    'payment_status' => $session->payment_status
                ], 400);
            }
            
            // Verificar que la sesión pertenece a este usuario
            if ($session->client_reference_id != $user->id) {
                Log::warning("Intento de activación con session_id ajeno: User {$user->id}, Session user {$session->client_reference_id}");
                return response()->json([
                    'success' => false,
                    'activated' => false,
                    'message' => 'Sesión inválida para este usuario'
                ], 403);
            }
            
            // Activar la suscripción
            $expirationDate = Carbon::now()->addMonth();
            $user->suscripcion_activa = true;
            $user->suscripcion_expira = $expirationDate;
            $user->save();
            
            Log::info("Suscripción activada exitosamente para usuario {$user->id} - Session: {$sessionId}");
            
            return response()->json([
                'success' => true,
                'activated' => true,
                'message' => '¡Suscripción activada exitosamente!',
                'subscription' => [
                    'active' => true,
                    'expires_at' => $expirationDate->toDateTimeString(),
                    'expires_at_formatted' => $expirationDate->format('d/m/Y'),
                    'days_remaining' => 30,
                    'plan' => 'monthly',
                    'amount_paid' => '$9.90 USD'
                ],
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ], 200);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Error de Stripe al activar suscripción: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'activated' => false,
                'message' => 'Error al comunicarse con Stripe',
                'error' => $e->getMessage()
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Error al activar suscripción: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'activated' => false,
                'message' => 'Error al activar suscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Callback de éxito desde Stripe
     * GET /api/stripe/success
     * 
     * Este endpoint puede ser llamado desde el deep link de Android
     * después de que Stripe redirija al usuario
     */
    public function success(Request $request)
    {
        try {
            $sessionId = $request->query('session_id');
            
            if (!$sessionId) {
                return response()->json([
                    'success' => false,
                    'activated' => false,
                    'message' => 'Session ID no proporcionado'
                ], 400);
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Recuperar la sesión de Stripe
            $session = StripeSession::retrieve($sessionId);
            
            if ($session->payment_status === 'paid') {
                // Obtener el usuario por el client_reference_id
                $userId = $session->client_reference_id;
                $user = \App\Models\User::find($userId);
                
                if ($user) {
                    $expirationDate = Carbon::now()->addMonth();
                    $user->suscripcion_activa = true;
                    $user->suscripcion_expira = $expirationDate;
                    $user->save();
                    
                    Log::info("Suscripción activada vía callback success para usuario {$userId}");
                    
                    return response()->json([
                        'success' => true,
                        'activated' => true,
                        'message' => '¡Pago exitoso! Tu suscripción ha sido activada',
                        'subscription' => [
                            'active' => true,
                            'expires_at' => $expirationDate->toDateTimeString(),
                            'expires_at_formatted' => $expirationDate->format('d/m/Y'),
                            'days_remaining' => 30,
                            'plan' => 'monthly'
                        ],
                        'next_step' => 'Puedes cerrar esta ventana y volver a la aplicación'
                    ], 200);
                } else {
                    Log::error("Usuario no encontrado con ID: {$userId}");
                    return response()->json([
                        'success' => false,
                        'activated' => false,
                        'message' => 'Usuario no encontrado'
                    ], 404);
                }
            }
            
            return response()->json([
                'success' => false,
                'activated' => false,
                'message' => 'El pago no fue completado',
                'payment_status' => $session->payment_status
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error en callback de éxito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'activated' => false,
                'message' => 'Error al procesar el pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Callback de cancelación desde Stripe
     * GET /api/stripe/cancel
     */
    public function cancel(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Pago cancelado por el usuario'
        ], 200);
    }

    /**
     * Webhook de Stripe para eventos
     * POST /api/stripe/webhook
     * 
     * Este webhook es llamado automáticamente por Stripe cuando ocurren eventos
     * Es la forma más confiable de activar suscripciones ya que es servidor-a-servidor
     */
    public function webhook(Request $request)
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            if ($endpoint_secret) {
                // Verificar la firma del webhook
                $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            } else {
                Log::warning('STRIPE_WEBHOOK_SECRET no configurado, saltando verificación de firma');
                $event = json_decode($payload);
            }

            Log::info('Webhook recibido: ' . $event->type);

            // Manejar diferentes tipos de eventos
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    
                    Log::info('Checkout session completed', [
                        'session_id' => $session->id,
                        'payment_status' => $session->payment_status,
                        'user_id' => $session->client_reference_id
                    ]);
                    
                    if ($session->payment_status === 'paid') {
                        $userId = $session->client_reference_id;
                        $user = \App\Models\User::find($userId);
                        
                        if ($user) {
                            // Verificar si ya está activa para evitar duplicados
                            if (!$user->suscripcion_activa || 
                                !$user->suscripcion_expira || 
                                Carbon::parse($user->suscripcion_expira)->isPast()) {
                                
                                $expirationDate = Carbon::now()->addMonth();
                                $user->suscripcion_activa = true;
                                $user->suscripcion_expira = $expirationDate;
                                $user->save();
                                
                                Log::info("✓ Suscripción ACTIVADA vía webhook para usuario {$userId}", [
                                    'expires_at' => $expirationDate->toDateTimeString(),
                                    'session_id' => $session->id
                                ]);
                            } else {
                                Log::info("Usuario {$userId} ya tiene suscripción activa, no se realizó cambio");
                            }
                        } else {
                            Log::error("Usuario no encontrado con ID: {$userId}");
                        }
                    }
                    break;

                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    Log::info('Payment intent succeeded', [
                        'payment_intent_id' => $paymentIntent->id,
                        'amount' => $paymentIntent->amount
                    ]);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    Log::warning('Payment intent failed', [
                        'payment_intent_id' => $paymentIntent->id,
                        'failure_message' => $paymentIntent->last_payment_error->message ?? 'Unknown error'
                    ]);
                    break;

                case 'charge.succeeded':
                    Log::info('Charge succeeded');
                    break;

                case 'charge.failed':
                    Log::warning('Charge failed');
                    break;

                default:
                    Log::info('Evento no manejado: ' . $event->type);
            }

            return response()->json(['received' => true], 200);

        } catch (\UnexpectedValueException $e) {
            // Firma inválida
            Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe signature verification exception: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Webhook error'], 500);
        }
    }

    /**
     * Obtener lista de usuarios con suscripción activa
     * GET /api/subscription/active-users
     * 
     * Este endpoint permite ver todos los usuarios que tienen suscripción activa
     * Útil para administración y debugging
     */
    public function getActiveSubscriptionUsers(Request $request)
    {
        try {
            // Obtener usuarios con suscripción activa
            $activeUsers = \App\Models\User::where('suscripcion_activa', true)
                ->whereNotNull('suscripcion_expira')
                ->get()
                ->map(function ($user) {
                    $expirationDate = Carbon::parse($user->suscripcion_expira);
                    $isExpired = $expirationDate->isPast();
                    $daysRemaining = $isExpired ? 0 : Carbon::now()->diffInDays($expirationDate);
                    
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'subscription_active' => $user->suscripcion_activa,
                        'subscription_expires' => $expirationDate->toDateTimeString(),
                        'expires_formatted' => $expirationDate->format('d/m/Y H:i'),
                        'days_remaining' => $daysRemaining,
                        'is_expired' => $isExpired,
                        'status' => $isExpired ? 'Expirada' : 'Activa'
                    ];
                });

            // Separar activos de expirados
            $activeNow = $activeUsers->where('is_expired', false)->values();
            $expired = $activeUsers->where('is_expired', true)->values();

            return response()->json([
                'success' => true,
                'total_users' => $activeUsers->count(),
                'active_now' => $activeNow->count(),
                'expired' => $expired->count(),
                'users' => [
                    'active' => $activeNow,
                    'expired' => $expired
                ],
                'message' => null
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener usuarios con suscripción activa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de suscripciones
     * GET /api/subscription/statistics
     */
    public function getSubscriptionStatistics(Request $request)
    {
        try {
            $totalUsers = \App\Models\User::count();
            
            // Usuarios con suscripción activa y no expirada
            $activeSubscriptions = \App\Models\User::where('suscripcion_activa', true)
                ->whereNotNull('suscripcion_expira')
                ->where('suscripcion_expira', '>', Carbon::now())
                ->count();
            
            // Usuarios con suscripción expirada
            $expiredSubscriptions = \App\Models\User::where('suscripcion_activa', true)
                ->whereNotNull('suscripcion_expira')
                ->where('suscripcion_expira', '<=', Carbon::now())
                ->count();
            
            // Usuarios sin suscripción
            $noSubscription = \App\Models\User::where(function($query) {
                $query->where('suscripcion_activa', false)
                      ->orWhereNull('suscripcion_activa')
                      ->orWhereNull('suscripcion_expira');
            })->count();

            return response()->json([
                'success' => true,
                'statistics' => [
                    'total_users' => $totalUsers,
                    'active_subscriptions' => $activeSubscriptions,
                    'expired_subscriptions' => $expiredSubscriptions,
                    'no_subscription' => $noSubscription,
                    'subscription_rate' => $totalUsers > 0 ? round(($activeSubscriptions / $totalUsers) * 100, 2) : 0
                ],
                'message' => null
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

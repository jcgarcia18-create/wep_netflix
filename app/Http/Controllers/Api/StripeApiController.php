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
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            Stripe::setApiKey(config('services.stripe.secret'));

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
                'success_url' => config('app.url') . '/api/stripe/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => config('app.url') . '/api/stripe/cancel',
                'client_reference_id' => $user->id, // Importante para identificar al usuario
                'customer_email' => $user->email,
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $session->id,
                'session_url' => $session->url,
                'message' => null
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al crear sesión de Stripe: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear sesión de pago',
                'error' => $e->getMessage()
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
     * Callback de éxito desde Stripe
     * GET /api/stripe/success
     */
    public function success(Request $request)
    {
        try {
            $sessionId = $request->query('session_id');
            
            if (!$sessionId) {
                return response()->json([
                    'success' => false,
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
                    $user->suscripcion_activa = true;
                    $user->suscripcion_expira = Carbon::now()->addMonth();
                    $user->save();
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Pago exitoso, suscripción activada',
                        'subscription' => [
                            'active' => true,
                            'expires_at' => $user->suscripcion_expira
                        ]
                    ], 200);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'El pago no fue completado'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error en callback de éxito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
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
                $event = json_decode($payload);
            }

            // Manejar diferentes tipos de eventos
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    
                    if ($session->payment_status === 'paid') {
                        $userId = $session->client_reference_id;
                        $user = \App\Models\User::find($userId);
                        
                        if ($user) {
                            $user->suscripcion_activa = true;
                            $user->suscripcion_expira = Carbon::now()->addMonth();
                            $user->save();
                            
                            Log::info("Suscripción activada para usuario {$userId}");
                        }
                    }
                    break;

                case 'payment_intent.succeeded':
                    Log::info('Payment intent succeeded');
                    break;

                case 'payment_intent.payment_failed':
                    Log::warning('Payment intent failed');
                    break;

                default:
                    Log::info('Evento no manejado: ' . $event->type);
            }

            return response()->json(['success' => true], 200);

        } catch (\UnexpectedValueException $e) {
            // Firma inválida
            Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook error'], 500);
        }
    }
}

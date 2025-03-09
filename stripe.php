<?php

/**
 * Stripe Checkout URL for PMPro Membership
 *
 * This file contains the functions related to generating the Stripe Checkout URL
 * for Paid Memberships Pro (PMPro) memberships.
 *
 * @link https://www.paidmembershipspro.com/
 *
 * @package StripeCheckout
 * @since StripeCheckout 1.0
 */

require_once __DIR__ . '/../../../vendor/autoload.php';
function pmpro_create_checkout_session($request)
{

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, Authorization");
	$param = $request->get_params();
	$level_id = $param['membership_level_id'];
	if (! class_exists('PMPro_Membership_Level')) {
		require_once(plugin_dir_path(__FILE__) . 'path/to/paid-memberships-pro/includes/class.membership_level.php');
	}
	$level = new PMPro_Membership_Level($level_id);
	if (!$level) {
		wp_send_json_error('Invalid membership level');
	}

	\Stripe\Stripe::setApiKey(STRIPE_SK);

	try {
		$checkout_session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [
				[
					'price_data' => [
						'currency' => 'usd',
						'product_data' => [
							'name' => $level->name,
						],
						'recurring' => [
							'interval' => strtolower($level->cycle_period),
							'interval_count' =>  (int)$level->cycle_number,
						],
						'unit_amount' => (int)$level->billing_amount * 100,
					],
					'quantity' => 1,
				],
			],
			'mode' => 'subscription',
			'success_url' => home_url('/payment-success/?session_id={CHECKOUT_SESSION_ID}'),
			'cancel_url' => home_url('/payment-cancel'),
		]);


		wp_send_json_success(['checkout_url' => $checkout_session->url]);
		// wp_send_json_success($level);
	} catch (Exception $e) {
		wp_send_json_error($e->getMessage());
	}
}

function pmpro_register_stripe_checkout_session_endpoint()
{
	register_rest_route('pmpro/v1', '/create-stripe-session', [
		'methods' => 'POST',
		'callback' => 'pmpro_create_checkout_session',
		'permission_callback' => '__return_true',
	]);
}
add_action('rest_api_init', 'pmpro_register_stripe_checkout_session_endpoint');

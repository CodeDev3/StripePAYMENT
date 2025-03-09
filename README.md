# Stripe Checkout Integration for Paid Memberships Pro (PMPro)

This repository integrates **Stripe Checkout** with the **Paid Memberships Pro (PMPro)** plugin for WordPress, enabling seamless subscription-based payments for your membership levels.

## Features

- **Stripe Checkout Session Creation**: Easily create Stripe Checkout sessions for PMPro membership levels.
- **Recurring Payments**: Supports subscription payments with configurable billing cycles (e.g., monthly, quarterly, annually).
- **REST API Endpoint**: Exposes a custom REST API endpoint for creating Stripe Checkout sessions programmatically.
- **Success and Cancel URLs**: Custom URLs for redirecting users upon successful or canceled payments.
- **CORS Support**: Handles CORS headers for API access.

## Requirements

- **WordPress**: You need a WordPress website with the **Paid Memberships Pro** plugin installed.
- **Stripe API**: You must have a **Stripe account** and obtain your **Secret Key** from the [Stripe Dashboard](https://dashboard.stripe.com/).
- **Stripe PHP Library**: This plugin uses the Stripe PHP SDK. You will need to install it via Composer:
  ```bash
  composer require stripe/stripe-php

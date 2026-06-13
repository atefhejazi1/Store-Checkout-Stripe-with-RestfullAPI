# Multi-Vendor Store with Checkout and Stripe Integration

## Overview
This is a Laravel-based multi-vendor e-commerce application that supports:
* Vendor-based product listing
* RESTful API with token-based authentication (Sanctum)
* Frontend for users to browse, add to cart, and checkout
* Online payment using Stripe
* Well-structured backend using Repository Design Pattern

## Features
* Vendor-specific product management
* Cart & Checkout system
* Online payments with Stripe
* Secure RESTful API with Sanctum
* Clean backend structure using Repository Pattern
* Ready-to-use Postman collection
* Video demo of the checkout and payment flow

## Technologies Used
* Laravel 12
* Sanctum for API Authentication
* Stripe API
* Repository Design Pattern
* MySQL
* Postman

## API Authentication
The API is secured using Laravel Sanctum. Users must authenticate to get a Bearer Token.

Include the token in the Authorization header:
```http
Authorization: Bearer YOUR_TOKEN_HERE

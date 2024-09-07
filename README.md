# Application Documentation

## Overview

This application is designed to manage products, orders, and pricing for users. It features:

- **Product Management:** Retrieval and display of product information.
- **Order Management:** Creation and management of orders with support for tax and discount calculations.
- **Configurable Pricing:** Price modifications such as taxes and discounts are managed through configurable settings.

## Architecture

### Controllers

#### ProductController

Handles product-related requests.

- **Methods:**
  - `index(Request $request)`: Retrieves and returns a paginated list of products. Optionally filters by user ID, applying user-specific pricing if applicable.

#### OrderController

Manages order creation and processing.

- **Methods:**
  - `store(Request $request)`: Validates and processes order requests. Retrieves products, calculates prices using the `PriceService`, applies tax and discount modifiers, and stores the order.

### Services

#### PriceService

A service responsible for fetching and calculating product prices. It abstracts the logic of retrieving prices based on user contracts or pricelists.

- **Methods:**
  - `getProductPrice(Product $product, ?User $user): float`: Retrieves the price of a product considering any applicable user-specific pricing.

#### Pricing Modifiers

- **TaxModifier**: Applies tax to a given subtotal.
- **DiscountModifier**: Applies a discount if the subtotal exceeds a specified threshold.

### Configurations

- **Tax and Discount Settings**

  Configuration values for tax rates and discount thresholds are stored in a configuration file for easy adjustments.

### Models

- **Order**: Represents an order and its associated metadata.
- **ProductOrder**: Represents individual items in an order.
- **OrderMeta**: Stores additional metadata related to orders.

## Configuration

### `config/pricing.php`

This configuration file contains tax and discount settings.

```php
return [
    'tax_rate' => 0.25, // 25% tax rate
    'discount' => [
        'threshold' => 100, // Minimum amount for discount
        'rate' => 0.10,     // 10% discount rate
    ],
];
```

## Usage

### Endpoints

#### GET /products

Retrieves a paginated list of products. Optionally filters by `user_id` to apply user-specific pricing.

**Parameters:**
- `user_id` (optional): User ID for fetching user-specific pricing.
- `page_size` (optional): Number of products per page.

**Response:**
- A JSON object containing a list of products and pagination information.

#### POST /orders

Creates a new order based on the provided request data.

**Parameters:**
- `user_id`: ID of the user placing the order.
- `products`: Array of products with `sku` and `quantity`.

**Response:**
- A JSON object with details of the created order, including the subtotal, tax amount, discount amount, and total amount.

## Dependency Injection

The `PriceService` is injected into controllers via the constructor, facilitating the separation of concerns and making the system more modular.

## Metadata Storage

Order metadata is stored using the `OrderMeta` model, which is created through a dedicated method `saveOrderMeta` in the `OrderController`. For more advanced metadata handling, consider using packages like `laravel-metadata`.

## Pricing Modifiers

### TaxModifier

- **Class:** `TaxModifier`
- **Responsibilities:** Applies a specified tax rate to a given subtotal.
- **Constructor Parameters:**
  - `float $rate`: The tax rate to apply.
- **Methods:**
  - `apply(float $subtotal): float`: Calculates the tax amount based on the provided subtotal.

### DiscountModifier

- **Class:** `DiscountModifier`
- **Responsibilities:** Applies a discount if the subtotal exceeds a specified threshold.
- **Constructor Parameters:**
  - `float $rate`: The discount rate to apply.
  - `float $threshold`: The minimum subtotal required for the discount.
- **Methods:**
  - `apply(float $subtotal): float`: Calculates the discount amount based on the provided subtotal.

### Seeder Instructions

To run the seeder, use the following Artisan command:

```bash

php artisan db:seed --class=DatabaseSeeder

```

Note: DatabaseSeeder is the main seeder that calls other seeders in the application.
## Future Enhancements

- **Dynamic Pricing Modifiers:** Implement more flexible and dynamic pricing rules.
- **Enhanced Metadata Handling:** Explore additional features for managing and querying metadata.

## Conclusion

This application is structured to be modular and easily extensible, with separate services for pricing logic and configuration management. By following SOLID principles, it ensures a maintainable and scalable codebase.

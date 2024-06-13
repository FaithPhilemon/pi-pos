# POS System

A Point of Sale (POS) system designed to manage sales, customers, and inventory efficiently. This project includes features like inventory management, customer management, holding sales, adding and removing items from the cart, and calculating totals with discounts.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Contributing](#contributing)
- [License](#license)

## Features

- Inventory management
- Supplier, customers, and staff management
- Add items to cart
- Update item quantities in cart
- Remove items from cart
- Calculate subtotal and total payable amount
- Apply percentage and fixed discounts
- Hold sales for later completion
- Print sales reciept
- Payment management
- Reporting

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/pos-system.git
    cd pos-system
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Create a copy of the `.env` file:
    ```bash
    cp .env.example .env
    ```

4. Generate application key:
    ```bash
    php artisan key:generate
    ```

5. Set up the database and configure the `.env` file with your database credentials.

6. Run migrations and seed the database:
    ```bash
    php artisan migrate --seed
    ```

7. Serve the application:
    ```bash
    php artisan serve
    ```

## Usage

1. Access the application at `http://localhost`.
2. Log in with the provided credentials or create a new account.
3. Navigate through the POS interface to add products, manage cart items, and complete sales.

### Adding Items to Cart

- Click on a product card to add the item to the cart.
- If the item already exists in the cart, the quantity will be updated.

### Removing Items from Cart

- Click the red `X` icon next to the item to remove it from the cart.

### Applying Discounts

- Enter a percentage discount or a fixed discount amount in the respective input fields.
- The total payable amount will be updated accordingly.

## Configuration

- Customize the product images, names, and prices in the `products` table.
- Configure customer and store information in the respective tables.

## Contributing

We welcome contributions to improve this project! Here are some ways you can help:

- Report bugs and issues
- Suggest new features
- Submit pull requests

### Steps to Contribute

1. Fork the repository.
2. Create a new branch:
    ```bash
    git checkout -b feature-name
    ```
3. Make your changes.
4. Commit your changes:
    ```bash
    git commit -m 'Add some feature'
    ```
5. Push to the branch:
    ```bash
    git push origin feature-name
    ```
6. Open a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

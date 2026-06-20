<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ORDER ITEMS TABLE ===\n";
try {
    $cols = \Schema::getColumnListing('order_items');
    echo "order_items columns: " . implode(', ', $cols) . "\n";
} catch (Exception $e) {
    echo "Missing order_items: " . $e->getMessage() . "\n";
}

echo "\n=== ADDRESSES TABLE ===\n";
try {
    $cols = \Schema::getColumnListing('addresses');
    echo "addresses columns: " . implode(', ', $cols) . "\n";
} catch (Exception $e) {
    echo "Missing addresses: " . $e->getMessage() . "\n";
}

echo "\n=== USER SUBSCRIPTIONS ===\n";
try {
    $cols = \Schema::getColumnListing('user_subscriptions');
    echo "user_subscriptions columns: " . implode(', ', $cols) . "\n";
} catch (Exception $e) {
    echo "Missing user_subscriptions: " . $e->getMessage() . "\n";
}

echo "\n=== REVIEWS TABLE ===\n";
try {
    $cols = \Schema::getColumnListing('reviews');
    echo "reviews columns: " . implode(', ', $cols) . "\n";
} catch (Exception $e) {
    echo "Missing reviews: " . $e->getMessage() . "\n";
}

echo "\n=== CART TABLE ===\n";
try {
    $cols = \Schema::getColumnListing('cart_items');
    echo "cart_items columns: " . implode(', ', $cols) . "\n";
} catch (Exception $e) {
    echo "Missing cart_items: " . $e->getMessage() . "\n";
}

echo "\n=== USER MODEL METHODS ===\n";
$admin = App\Models\User::where('role','admin')->first();
if ($admin) {
    echo "Admin isPremium(): " . ($admin->isPremium() ? 'true' : 'false') . "\n";
    echo "Admin isAdmin(): " . ($admin->isAdmin() ? 'true' : 'false') . "\n";
}

echo "\n=== GENRES TABLE ===\n";
$cols = \Schema::getColumnListing('genres');
echo "genres columns: " . implode(', ', $cols) . "\n";

echo "\n=== PRODUCTS TABLE ===\n";
$cols = \Schema::getColumnListing('products');
echo "products columns: " . implode(', ', $cols) . "\n";

echo "\nDone.\n";

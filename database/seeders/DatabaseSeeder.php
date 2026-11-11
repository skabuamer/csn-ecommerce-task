<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => 'password', 'role' => 'admin']);
        $owner1 = User::create(['name' => 'Owner One', 'email' => 'owner1@example.com', 'password' => 'password', 'role' => 'shop_owner']);
        $owner2 = User::create(['name' => 'Owner Two', 'email' => 'owner2@example.com', 'password' => 'password', 'role' => 'shop_owner']);

        $shop1 = Shop::create(['owner_id' => $owner1->id, 'name' => 'Tech Hub', 'slug' => 'tech-hub']);
        $shop2 = Shop::create(['owner_id' => $owner2->id, 'name' => 'Home Corner', 'slug' => 'home-corner']);

        $product1 = Product::create(['created_by' => $admin->id, 'title' => 'Wireless Mouse', 'details' => '2.4GHz mouse', 'price' => 15]);
        $product2 = Product::create(['created_by' => $admin->id, 'title' => 'Desk Lamp', 'details' => 'LED lamp', 'price' => 20]);
        Product::create(['created_by' => $admin->id, 'title' => 'Unlisted Product', 'details' => 'Not in any shop', 'price' => 9]);

        ShopProduct::create(['shop_id' => $shop1->id, 'product_id' => $product1->id, 'price' => 18]);
        ShopProduct::create(['shop_id' => $shop2->id, 'product_id' => $product1->id, 'price' => 16.5, 'title' => 'Mouse (Home Corner Edition)']);
        ShopProduct::create(['shop_id' => $shop2->id, 'product_id' => $product2->id, 'price' => 22]);
    }
}

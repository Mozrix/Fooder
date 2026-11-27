<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerCartTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_can_add_a_menu_to_the_session_cart_and_checkout_uses_toko_id(): void
    {
        $produk = $this->createProduk();

        $this->post(route('customer.keranjang.add'), [
            'produk_id' => $produk->id,
            'jumlah' => 1,
        ])->assertRedirect(route('customer.pesanan.checkout'));

        $this->assertSame(1, session('customer_cart.items.' . $produk->id));

        $this->get(route('customer.pesanan.checkout'))
            ->assertOk()
            ->assertSee('name="toko_id"', false)
            ->assertSee('name="items[' . $produk->id . '][produk_id]"', false)
            ->assertSee('Masuk untuk memesan');
    }

    public function test_cart_rejects_products_from_another_store(): void
    {
        $produkAwal = $this->createProduk('Toko Pertama');
        $produkLain = $this->createProduk('Toko Kedua');

        $this->withSession([
            'customer_cart' => [
                'toko_id' => $produkAwal->toko_id,
                'items' => [$produkAwal->id => 1],
            ],
        ])->post(route('customer.keranjang.add'), [
            'produk_id' => $produkLain->id,
            'jumlah' => 1,
        ])->assertSessionHasErrors('cart');

        $this->assertSame(1, session('customer_cart.items.' . $produkAwal->id));
        $this->assertNull(session('customer_cart.items.' . $produkLain->id));
    }

    private function createProduk(string $namaToko = 'Toko Test'): Produk
    {
        $owner = User::create([
            'nama' => 'Seller Test',
            'email' => uniqid('seller-', true) . '@example.test',
            'password' => 'password',
            'role' => 'seller',
        ]);
        $kategori = Kategori::create(['nama_kategori' => 'Makanan']);
        $toko = Toko::create([
            'user_id' => $owner->id,
            'nama_toko' => $namaToko,
        ]);

        return Produk::create([
            'toko_id' => $toko->id,
            'kategori_id' => $kategori->id,
            'nama_produk' => 'Menu Test',
            'deskripsi' => 'Menu pengujian.',
            'harga' => 15000,
            'tipe' => 'makanan berat',
            'stok' => 5,
            'in_stock' => true,
        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;

class StoreShow extends Component
{
    public $store;
    public $categories;
    public $selectedCategory = 'all';
    public $products;
    public $productsPerPage = 4;
    public $showLoadMore = false;

    public function render()
    {
        if (!$this->store) {
            return view('livewire.coming-soon')
                ->layout('components.layouts.app', ['hideBottomNav' => true]);
        }

        return view('livewire.store-show');
    }

    public function mount()
    {
        $this->store = Store::first() ?? new Store([
            'banner' => [],
            'info_swiper' => []
        ]);
        $this->categories = Category::all();
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $query = Product::query();

        if ($this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }

        $allProducts = $query->get();
        $this->products = $allProducts->take($this->productsPerPage);
        $this->showLoadMore = $allProducts->count() > $this->productsPerPage;
    }

    public function loadMore()
    {
        $query = Product::query();

        if ($this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }

        $this->productsPerPage += 4;
        $allProducts = $query->get();
        $this->products = $allProducts->take($this->productsPerPage);
        $this->showLoadMore = $allProducts->count() > $this->productsPerPage;
    }

    public function setCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->productsPerPage = 4; // Reset to initial count when changing category
        $this->loadProducts();
    }
}

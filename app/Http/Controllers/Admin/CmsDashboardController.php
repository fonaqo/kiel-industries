<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class CmsDashboardController extends Controller
{
    public function index(): View
    {
        $pendingOrders = Order::query()->where('status', 'processing')->count();

        return view('cms-admin.dashboard', [
            'page' => 'admin',
            'title' => '',
            'pendingOrders' => $pendingOrders,
            'statCards' => [
                [
                    'label' => 'Commandes',
                    'hint' => 'Suivi & statuts',
                    'value' => Order::query()->count(),
                    'href' => route('admin.orders'),
                    'icon' => 'receipt_long',
                    'tone' => 'wine',
                ],
                [
                    'label' => 'Produits',
                    'hint' => 'Catalogue boutique',
                    'value' => Product::query()->count(),
                    'href' => route('admin.cms.products.index'),
                    'icon' => 'inventory_2',
                    'tone' => 'green',
                ],
                [
                    'label' => 'Actualités',
                    'hint' => 'Articles publiés',
                    'value' => Post::query()->count(),
                    'href' => route('admin.cms.posts.index'),
                    'icon' => 'newspaper',
                    'tone' => 'green',
                ],
                [
                    'label' => 'Clients',
                    'hint' => 'Comptes inscrits',
                    'value' => User::query()->where('is_super_admin', false)->count(),
                    'href' => route('admin.users'),
                    'icon' => 'group',
                    'tone' => 'neutral',
                ],
            ],
            'quickActions' => [
                ['href' => route('admin.cms.products.create'), 'icon' => 'add_circle', 'title' => 'Nouveau produit', 'desc' => 'Ajouter au catalogue'],
                ['href' => route('admin.cms.posts.create'), 'icon' => 'edit_note', 'title' => 'Nouvelle actualité', 'desc' => 'Publier un article'],
                ['href' => route('admin.cms.settings.edit', ['tab' => 'reseaux']), 'icon' => 'share', 'title' => 'Réseaux sociaux', 'desc' => 'Liens header & footer'],
                ['href' => route('admin.orders'), 'icon' => 'local_shipping', 'title' => 'Suivi commandes', 'desc' => 'Statuts & détails'],
                ['href' => route('admin.cms.settings.edit'), 'icon' => 'tune', 'title' => 'Paramètres', 'desc' => 'SEO, organisation, réseaux'],
            ],
            'recentOrders' => Order::query()->latest()->take(5)->get(),
        ]);
    }
}

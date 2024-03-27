<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use App\Models\Utility;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {

        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $totalRoles = Role::count();
        $totalUsers = User::count();
        $totalUtilities = Utility::count();
        return Inertia::render('admin/dashboard/index', [
            "title" => 'Dashboard',
            "totalBooks" => $totalBooks,
            "totalCategories" => $totalCategories,
            "totalRoles" => $totalRoles,
            "totalUsers" => $totalUsers,
            "totalUtilities" => $totalUtilities
        ]);
    }
}

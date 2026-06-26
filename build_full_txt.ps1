$files = @(
    "app\Livewire\Admin\Dashboard.php",
    "app\Livewire\Admin\Users.php",
    "app\Livewire\Admin\Products.php",
    "app\Livewire\Admin\Orders.php",
    "app\Livewire\Admin\Games.php",
    "app\Livewire\Admin\Genres.php",
    "app\Livewire\Admin\Auctions.php",
    "app\Livewire\Admin\Coupons.php",
    "resources\views\livewire\admin\dashboard.blade.php",
    "resources\views\livewire\admin\users.blade.php",
    "resources\views\livewire\admin\products.blade.php",
    "resources\views\livewire\admin\orders.blade.php",
    "resources\views\livewire\admin\games.blade.php",
    "resources\views\livewire\admin\genres.blade.php",
    "resources\views\livewire\admin\auctions.blade.php",
    "resources\views\layouts\v2\admin.blade.php",
    "resources\views\layouts\v2\partials\admin-mobile-menu.blade.php",
    "app\Http\Middleware\RoleMiddleware.php"
)

$output = "fileadminfull.txt"
Clear-Content $output -ErrorAction SilentlyContinue

foreach ($f in $files) {
    if (Test-Path $f) {
        Add-Content -Path $output -Value "==================================================================="
        Add-Content -Path $output -Value "FILE: $f"
        Add-Content -Path $output -Value "==================================================================="
        Get-Content $f | Add-Content -Path $output
        Add-Content -Path $output -Value "`n`n"
    } else {
        Add-Content -Path $output -Value "==================================================================="
        Add-Content -Path $output -Value "FILE: $f (NOT FOUND)"
        Add-Content -Path $output -Value "==================================================================="
        Add-Content -Path $output -Value "`n`n"
    }
}
Write-Output "Done creating fileadminfull.txt"

<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Coupon;
use App\Traits\WithToast;

#[Layout('layouts.admin')]
class Coupons extends Component {
    use WithPagination, WithToast;

    public $search = '';
    public $showModal = false;
    
    // Form fields
    public $couponId;
    public $code, $name, $description, $type = 'fixed', $value = 0;
    public $min_order, $max_uses, $starts_at, $ends_at, $is_active = true;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function create() {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id) {
        $coupon = Coupon::findOrFail($id);
        $this->couponId = $coupon->id;
        $this->code = $coupon->code;
        $this->name = $coupon->name;
        $this->description = $coupon->description;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->min_order = $coupon->min_order;
        $this->max_uses = $coupon->max_uses;
        $this->starts_at = $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '';
        $this->ends_at = $coupon->ends_at ? $coupon->ends_at->format('Y-m-d\TH:i') : '';
        $this->is_active = $coupon->is_active;
        
        $this->showModal = true;
    }

    public function save() {
        $this->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $this->couponId,
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        $data = [
            'code' => strtoupper($this->code),
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'value' => $this->value,
            'min_order' => $this->min_order ?: null,
            'max_uses' => $this->max_uses ?: null,
            'starts_at' => $this->starts_at ?: null,
            'ends_at' => $this->ends_at ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->couponId) {
            $coupon = Coupon::find($this->couponId);
            $coupon->update($data);
            $this->toast('Coupon updated successfully!', 'success');
        } else {
            Coupon::create($data);
            $this->toast('Coupon created successfully!', 'success');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete($id) {
        Coupon::find($id)->delete();
        $this->toast('Coupon deleted!', 'success');
    }

    private function resetForm() {
        $this->reset(['couponId', 'code', 'name', 'description', 'type', 'value', 
                     'min_order', 'max_uses', 'starts_at', 'ends_at', 'is_active']);
    }

    public function render() {
        $coupons = Coupon::query()
            ->when($this->search, function($query) {
                $query->where('code', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.coupons', [
            'coupons' => $coupons
        ]);
    }
}
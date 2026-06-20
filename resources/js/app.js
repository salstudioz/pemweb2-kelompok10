import './bootstrap';
import mask from '@alpinejs/mask';
import collapse from '@alpinejs/collapse';

document.addEventListener('livewire:init', () => {
    Livewire.Alpine.plugin(mask);
    Livewire.Alpine.plugin(collapse);
});

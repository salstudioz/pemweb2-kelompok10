<div 
    x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        timeoutId: null,
        trigger(msg, t) {
            this.message = msg;
            this.type = t;
            this.show = true;
            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => this.show = false, 4000);
        }
    }" 
    x-init="
        @if(session()->has('success'))
            trigger('{{ addslashes(session('success')) }}', 'success');
        @elseif(session()->has('error'))
            trigger('{{ addslashes(session('error')) }}', 'error');
        @elseif(session()->has('order_success'))
            trigger('{{ addslashes(session('order_success')) }}', 'success');
        @elseif(session()->has('info'))
            trigger('{{ addslashes(session('info')) }}', 'info');
        @endif
    "
    @notify.window="trigger($event.detail[0].message, $event.detail[0].type)"
    class="fixed bottom-5 right-5 z-[9999] max-w-sm w-full pointer-events-none"
>
    <div 
        x-show="show" 
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="pointer-events-auto rounded-xl shadow-2xl border overflow-hidden"
        :class="{
            'bg-white border-green-200': type === 'success',
            'bg-white border-red-200': type === 'error',
            'bg-white border-blue-200': type === 'info',
            'bg-white border-yellow-200': type === 'warning'
        }"
        style="display: none;"
    >
        <div class="flex items-start gap-3 p-4">
            <!-- Icon -->
            <div class="flex-shrink-0 mt-0.5">
                <template x-if="type === 'success'">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </template>
                <template x-if="type === 'error'">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                </template>
                <template x-if="type === 'info'">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </template>
                <template x-if="type === 'warning'">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </template>
            </div>
            <!-- Message -->
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900" 
                   :class="{
                       'text-green-800': type === 'success',
                       'text-red-800': type === 'error',
                       'text-blue-800': type === 'info',
                       'text-yellow-800': type === 'warning'
                   }"
                   x-text="type.charAt(0).toUpperCase() + type.slice(1)"></p>
                <p class="text-sm text-gray-600 mt-0.5" x-text="message"></p>
            </div>
            <!-- Close button -->
            <button @click="show = false; clearTimeout(timeoutId)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition ml-1 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <!-- Progress bar -->
        <div class="h-1 w-full" :class="{
            'bg-green-100': type === 'success',
            'bg-red-100': type === 'error',
            'bg-blue-100': type === 'info',
            'bg-yellow-100': type === 'warning'
        }">
            <div x-show="show" class="h-full origin-left transition-all"
                 :class="{
                     'bg-green-500': type === 'success',
                     'bg-red-500': type === 'error',
                     'bg-blue-500': type === 'info',
                     'bg-yellow-500': type === 'warning'
                 }"
                 style="animation: shrink 4s linear forwards"
            ></div>
        </div>
    </div>
</div>

<style>
@keyframes shrink {
    from { width: 100%; }
    to { width: 0%; }
}
</style>
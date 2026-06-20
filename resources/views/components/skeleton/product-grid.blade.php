<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach(range(1, 8) as $i)
        <div class="animate-pulse">
            <div class="bg-sigmaven-border aspect-[2/3] rounded-sm"></div>
            <div class="h-4 bg-sigmaven-border rounded mt-3 w-3/4"></div>
            <div class="h-3 bg-sigmaven-border rounded mt-2 w-1/2"></div>
            <div class="h-5 bg-sigmaven-border rounded mt-2 w-1/3"></div>
        </div>
    @endforeach
</div>

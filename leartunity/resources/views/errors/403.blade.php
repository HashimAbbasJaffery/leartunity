<x-layout>
    @php 
        $is_banned = \App\Models\User::find(auth()->id())->isBanned();
    @endphp
    
    @if(!$is_banned)
        <section class="error container mx-auto">
            <img class="mx-auto" src="{{ asset("img/403.jpg") }}"  height="400"width="600" />
            
        </section>
    @else 
        <section class="error container mx-auto">
            <img class="mx-auto" src="{{ asset("img/banned.jpg") }}" class="banned" height="400" width="600" />
            <p class="text-center my-3" style="font-size: 14px;">If you got kicked out by mistake, don't worry! Just send a quick email to <a class="underline" href="mailto:habbas2121@outlook.com">habbas2121@outlook.com</a> and ask them to let you back in.</p>
        </section>
    @endif
</x-layout>
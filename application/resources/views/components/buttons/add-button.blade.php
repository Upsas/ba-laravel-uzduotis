@props(['iconSize' => ''])
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-80   disabled:opacity-25 transition ease-in-out duration-150']) }}>
    <i class="fas fa-plus-circle fa-{{$iconSize}}"></i>
    {{ $slot }}
</button>

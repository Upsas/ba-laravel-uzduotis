@props(['iconSize' => ''])
<button {{ $attributes->merge(['type' => 'submit', 'class' => ' items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase hover:opacity-80   disabled:opacity-25 transition ease-in-out duration-150 mr-1 mb-1']) }}>
    <i class="fas fa-plus-circle fa-{{$iconSize}}"></i>
    {{ $slot }}
</button>

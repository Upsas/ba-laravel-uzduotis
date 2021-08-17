@props(['iconSize' => ''])
<button {{ $attributes->merge(['type' => 'submit', 'class' => ' bg-red-500 text-white font-bold uppercase text-sm px-4 py-2 rounded-lg shadow-lg hover:bg-opacity-75 outline-none focus:outline-none mr-1 mb-1']) }}>
    <i class="fas fa-times-circle fa-{{$iconSize}}"></i>
</button>

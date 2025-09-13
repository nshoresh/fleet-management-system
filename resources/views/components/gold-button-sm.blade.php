<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-transparent   text-yellow-500 rounded-md font-semibold text-xs text-gold-500 uppercase tracking-widest hover:bg-gray-50 hover:text-gold-600 active:bg-yellow-100 active:text-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

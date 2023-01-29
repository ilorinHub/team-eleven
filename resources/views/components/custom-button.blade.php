<button {{ $attributes->merge(['type' => 'submit', 'class' => "bg-purple-600 py-1 px-9 text-center tracking-wide text-lg rounded space-x-2 items-center font-medium text-gray-50 relative z-10 overflow-clip before:absolute before::content-[''] before:bg-[#171d24] before:transition-transform before:transform-gpu before:duration-500 before:scale-x-0 before:w-full before:h-full before:top-0 before:left-0 before:-z-10 before:origin-top-right hover:before:scale-x-100 hover:before:origin-top-left"]) }}>
    {{ $slot }}
</button>

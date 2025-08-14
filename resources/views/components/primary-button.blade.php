<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden h-10 px-4 text-[#121417] text-sm font-bold leading-normal tracking-[0.015em] rounded-full bg-blue-500']) }}>
    <span class="truncate">
    {{ $slot }}
    </span>
</button>


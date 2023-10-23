<div id="{{ $id ?? 'newProjectModal' }}"
    class="hidden flex justify-center w-full h-full overflow-x-hidden overflow-y-auto fixed top-0 left-0 bg-gray-500 bg-opacity-40 z-50 justify-center items-center">
    <div class="fixed w-full {{ $width ?? 'max-w-sm' }} px-4 h-full md:h-auto bg-white shadow relative">
        <p class="closeModal flex justify-end text-gray-400 cursor-pointer">x</p>
        <div class="py-3 my-1 px-3">
            <h1 class="modalTitle text-2xl font-bold">
                {{ $title }}
            </h1>
            {{ $slot }}
        </div>
    </div>
</div>

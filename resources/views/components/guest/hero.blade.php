<section class="relative top-0 flex flex-col items-center justify-center w-full min-h-screen -mt-24 bg-white lg:min-h-[60svh]">

    <div class="flex flex-col items-center justify-between flex-1 w-full max-w-2xl gap-6 px-8 pt-32 mx-auto text-left md:px-12 xl:px-20 lg:pt-32 lg:pb-16 lg:max-w-7xl lg:flex-row">
        <div class="w-full lg:w-1/2">
            <h1 class="text-6xl font-bold tracking-tighter text-left sm:text-7xl md:text-8xl sm:text-center lg:text-left text-zinc-900 text-balance">
                <span class="block origin-left lg:scale-90 text-nowrap">Welcome</span> <span class="pr-4 text-transparent text-neutral-600 bg-clip-text bg-gradient-to-b from-neutral-900 to-neutral-500">to {{ config('app.name') }}</span>
            </h1>
            <p class="mx-auto mt-5 text-2xl font-normal text-left sm:max-w-md lg:ml-0 lg:max-w-md sm:text-center lg:text-left text-zinc-500">
                Get your voice heard!<span class="hidden sm:inline"> Freely</span>.
            </p>
            <div class="flex flex-col items-center justify-center gap-3 mx-auto mt-8 md:gap-2 lg:justify-start md:ml-0 md:flex-row">
                <x-button size="lg" class="w-full lg:w-auto">Report</x-button>
                <x-button size="lg" color="secondary" class="w-full lg:w-auto">Email</x-button>
            </div>
        </div>
        <div class="flex items-center justify-center w-full mt-12 lg:w-1/2 lg:mt-0">
            <img alt="Hero Image" class="relative w-full lg:scale-125 xl:translate-x-6" src="/wave/img/character.png" style="max-width:450px;">
        </div>
    </div>
</section>

<x-layouts.app>

    <x-app.heading
        title="Dashboard"
        description="Welcome to an example application dashboard. Find more resources below."
        :border="false"
    />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-app.container x-data class="lg:space-y-6" x-cloak>

                    <x-app.alert id="dashboard_alert" class="hidden lg:flex">This is the dashboard where users can manage settings and access features.</x-app.alert>


                    <div class="flex flex-col w-full mt-5 space-y-5 md:flex-row md:space-y-0 md:mb-0 md:space-x-5">
                        <x-app.dashboard-card
                            href="https://github.com/arismetyogi/larawire"
                            target="_blank"
                            title="Github Repo"
                            description="View the source code and submit a Pull Request"
                            link_text="View on Github"
                            image="/img/laptop.png"
                        />
                        <x-app.dashboard-card
                            href="https://kimiafarmaapotek.co.id"
                            target="_blank"
                            title="Official Website"
                            description="Visit our Company's official website"
                            link_text="Visit Company Website"
                            image="/img/globe.png"
                        />
                    </div>

                    <div class="mt-5 space-y-5">

                    </div>
                </x-app.container>

            </div>
        </div>
    </div>
</x-layouts.app>

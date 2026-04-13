<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1">

                    </div>
                    <div class="w-[320px] border-1 px-8">
                        <x-user-avatar :user="$user" size="h-16 w-16" />
                        <h3>{{ $user->name }}</h3>
                        <p class="text-gray-500">26k followers</p>
                        <p>{{ $user->bio }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

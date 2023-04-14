<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Members') }}
        </h1>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div>
                        <form class="d-flex align-items-stretch justify-content-center gap-3" id="search" action="{{route('profile.members')}}" method="GET">
                            @csrf
                            <input class="rounded w-100 text-dark" style="max-width: 992px;" type="text" name="search" id="search" placeholder="Search members" required>
                            <input type="submit" class="btn text-light px-5" style="background-color: #198754 !important;">
                        </form>
                    </div>

                    <hr class="w-100 my-5">

                    @if (count($users) >= 1)

                        @foreach ($users as $user)

                            <div class="w-75 mb-5" id="user" style="margin: 0 auto;">
                                <div class="d-flex align-items-center gap-3">
                                    @include('components.user-avatar', ['data' => $user->image, 'size' => "width: 200px; height: 200px; border-radius: 100%;"])
                                    <div>
                                        <span class="fs-5 fw-bold">&#64;{{$user->nick}}</span>
                                        <h2 class="fs-3 fw-bold mt-2 mb-1">{{$user->name}} {{$user->surname}}</h2>
                                        <p class="mb-3">Joined {{$user->created_at->diffForHumans(null, false, false, 1)}}</p>
                                        <a href="{{route('profile', ['id' => $user->id])}}" class="btn btn-success">See profile</a>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                        <div class="clearfix"></div>
                        {{$users->links()}}

                    @else

                        <h2 class="mb-4 fs-5 text-center">No results</h2>

                    @endif

            </div>
        </div>
    </div>
</x-app-layout>

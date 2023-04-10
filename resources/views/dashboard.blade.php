<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status') === 'image-uploaded')
                <x-success>{{ __('Image uploaded succesfully') }}</x-success>
            @endif
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($images as $image)
                        <div class="card w-75 text-bg-dark mb-5" style="margin: 0 auto;">
                            <div class="card-header px-5 py-3 d-flex align-items-center gap-3">
                                @if ($image->user->image)
                                    <x-user-avatar></x-user-avatar>
                                @endif
                                <h3>{{$image->user->name}} {{$image->user->surname}}<span class="text-secondary"> | &#64;{{$image->user->nick}}</span></h3>
                            </div>
                            <div class="card-body p-0">
                                <a href="{{route('image.detail', ['id' => $image->id])}}"><img src="{{route('image.file', ['filename' => $image->image_path])}}"></a>
                                <div class="px-5 py-4 d-flex justify-content-between align-items-center">
                                    <div class="card-text mb-0" style="width: 65%;">
                                        <span class="text-secondary">&#64;{{$image->user->nick}} | {{$image->created_at->diffForHumans(null, false, false, 1) }} </span>
                                        <p class="mb-0">{{$image->description}}</p>
                                    </div>
                                    <div class="card-link d-flex gap-4">
                                        <button><img style="width=25px; height: 25px;"" src="{{asset('img/light-heart.png')}}" alt=""></button>
                                        <a class="btn btn-warning fw-bold" href="">Comments <span>({{count($image->comments)}})</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="clearfix"></div>
                    {{$images->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

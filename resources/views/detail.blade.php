<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Post By <span class="font-semibold">{{$image[0]->user->name}} {{$image[0]->user->surname}}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 card text-bg-dark mb-5" style="margin-bottom: 0 !important;">
            <div class="card-header px-5 py-3 d-flex align-items-center gap-3">
                @if ($image[0]->user->image)
                    <x-user-avatar></x-user-avatar>
                @endif
                <h3>{{$image[0]->user->name}} {{$image[0]->user->surname}}<span class="text-secondary"> | &#64;{{$image[0]->user->nick}}</span></h3>
            </div>
            <div class="card-body p-0">
                <a href="{{route('image.detail', ['id' => $image[0]->id])}}"><img src="{{route('image.file', ['filename' => $image[0]->image_path])}}"></a>
                <div class="px-5 py-4 d-flex justify-content-between align-items-center">
                    <div class="card-text mb-0">
                        <span class="text-secondary">&#64;{{$image[0]->user->nick}}</span>
                        <p class="mb-0">{{$image[0]->description}}</p>
                    </div>
                    <div class="card-link d-flex gap-4">
                        <button><img style="width=25px; height: 25px;"" src="{{asset('img/light-heart.png')}}" alt=""></button>
                    </div>
                </div>
                <div class="px-5">
                    <h4 class="fs-3">Comments ({{count($image[0]->comments)}})</h4>
                    <hr class="w-100">
                    <form action="" method="POST">
                        <div><textarea class="w-100 bg-dark" name="comment" id="comment" cols="30" rows="5"></textarea></div>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
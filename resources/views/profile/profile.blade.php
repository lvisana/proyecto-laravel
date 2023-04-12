<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <section class="w-75" id="user" style="margin: 0 auto;">
                        <div class="d-flex align-items-center gap-3">
                            @include('components.user-avatar', ['data' => Auth::user()->image, 'size' => "width: 200px; height: 200px; border-radius: 100%;"])
                            <div>
                                <span class="fs-5 fw-bold">&#64;{{$user[0]->nick}}</span>
                                <h2 class="fs-3 fw-bold mt-2 mb-1">{{$user[0]->name}} {{$user[0]->surname}}</h2>
                                <p>Joined {{$user[0]->created_at->diffForHumans(null, false, false, 1)}}</p>
                            </div>
                        </div>
                    </section>

                        <hr class="w-75 my-4" style="margin: 0 auto;">

                        @foreach ($images as $key => $image)
                        <div class="card w-75 dark:bg-gray-800 text-light mb-5" style="margin: 0 auto;">
                            <div class="card-header px-5 py-3 d-flex align-items-center gap-3">
                                @include('components.user-avatar', ['data' => $image->user->image, 'size' => 'width: 50px; height: 50px; border-radius: 100%;'])
                                <p>{{$image->user->name}} {{$image->user->surname}}<span class="text-secondary"> | &#64;{{$image->user->nick}}</span></p>
                            </div>

                            <div class="card-body p-0">
                                <a href="{{route('image.detail', ['id' => $image->id])}}"><img src="{{route('image.file', ['filename' => $image->image_path])}}"></a>
                                <div class="px-5 py-4 d-flex justify-content-between align-items-center">

                                    <div class="card-text mb-0" style="width: 65%;">
                                        <span class="text-secondary">&#64;{{$image->user->nick}} | {{$image->created_at->diffForHumans(null, false, false, 1) }} </span>
                                        <p class="mb-0">{{$image->description}}</p>
                                    </div>

                                    <div class="card-link d-flex gap-4">
                                        <div class="d-flex align-items-center gap-2">
                                        @php  $is_like = false; @endphp

                                        @foreach ($image->likes as $like) 
                                            @if ($like->user_id === Auth::user()->id)
                                                @php  $is_like = true; @endphp
                                            @endif
                                        @endforeach

                                        @if($is_like) 
                                            <img class="like-btn btn-liked" id="{{$image->id}}" style="width=25px; height: 25px;" src="{{asset('img/red-heart.png')}}" alt="">
                                        @else
                                            <img class="like-btn" id="{{$image->id}}" style="width=25px; height: 25px;" src="{{asset('img/light-heart.png')}}" alt="">
                                        @endif

                                            <span class="text-secondary" data-id="likeCount-{{$key}}">{{count($image->likes)}}</span>
                                        </div>
                                        <a class="btn btn-warning fw-bold" href="{{route('image.detail', ['id' => $image->id])}}#comments">Comments <span>({{count($image->comments)}})</span></a>
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
</x-app-layout>

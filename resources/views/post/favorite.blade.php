<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(isset($favorite))
                        @foreach ($favorite as $key => $like)
                            <div class="card w-75 dark:bg-gray-800 text-light mb-5" style="margin: 0 auto;">
                                <div class="card-header px-5 py-3">
                                    
                                    <div class="d-flex justify-content-between align-items-center">

                                        <div class="d-flex align-items-center gap-3">
                                            @include('components.user-avatar', ['data' => $like->image->user->image, 'size' => 'width: 50px; height: 50px; border-radius: 100%;'])
                                            <p>{{$like->image->user->name}} {{$like->image->user->surname}}<span class="text-secondary"> | &#64;{{$like->image->user->nick}}</span></p>
                                        </div>
                    
                                        @if ($like->image->user_id == \Auth::user()->id)
                                            <x-dropdown align="right" width="48">
                    
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150" style=" gap: 1rem;">
                                                        <img src="{{asset('img/light-ellipsis.png')}}" style="width: 35px; height: 35px;" alt="">
                                                    </button>
                                                </x-slot>
                    
                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('image.create', ['edit' => $like->image->id])">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>
                    
                                                    <x-dropdown-link class="text-danger" :href="route('image.delete', ['id' => $like->image->id])">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </x-slot>
                    
                                            </x-dropdown>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <a href="{{route('image.detail', ['id' => $like->image->id])}}"><img src="{{route('image.file', ['filename' => $like->image->image_path])}}"></a>
                                    <div class="px-5 py-4 d-flex justify-content-between align-items-center">

                                        <div class="card-text mb-0" style="width: 65%;">
                                            <span class="text-secondary">&#64;{{$like->image->user->nick}} | {{$like->image->created_at->diffForHumans(null, false, false, 1) }} </span>
                                            <p class="mb-0">{{$like->image->description}}</p>
                                        </div>

                                        <div class="card-link d-flex gap-4">
                                            <div class="d-flex position-relative align-items-center gap-2">
                                                @php  $is_like = false; @endphp

                                                @foreach ($like->image->likes as $likes) 
                                                    @if ($likes->user_id === Auth::user()->id)
                                                        @php  $is_like = true; @endphp
                                                    @endif
                                                @endforeach

                                                @if($is_like) 
                                                    <img class="like-btn btn-liked" id="{{$like->image->id}}" style="width=25px; height: 25px;" src="{{asset('img/red-heart.png')}}" alt="">
                                                @else
                                                    <img class="like-btn" id="{{$like->image->id}}" style="width=25px; height: 25px;" src="{{asset('img/light-heart.png')}}" alt="">
                                                @endif

                                                <div id="likes" data-id="likeCount-{{$key}}" class="d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                                    <span class="text-secondary">{{count($like->image->likes)}}</span>
                                                    <div>
                                                        @if (count($like->image->likes) >= 1)
                                                            <ul class="d-none rounded text-dark py-2 px-4">
                                                                @foreach ($like->image->likes as $likes)
                                                                    <li class="d-flex align-items-center gap-1 mb-2 border-bottom pb-1">
                                                                        @include('components.user-avatar', ['data' => $likes->user->image, 'size' => 'width: 30px; height: 30px; border-radius: 100%;'])
                                                                        <p>{{$likes->user->name}} {{$likes->user->surname}}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <a class="btn btn-warning fw-bold" href="{{route('image.detail', ['id' => $like->image->id])}}#comments">Comments <span>({{count($like->image->comments)}})</span></a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        @endforeach

                        <div class="clearfix"></div>
                        {{$favorite->links()}}
                    </div>

                @else 
                    <h2 class="text-center fs-5">No favorite images yet</h2>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>

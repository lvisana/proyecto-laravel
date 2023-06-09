<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status') === 'image-uploaded')
                <x-success>{{ __('Image uploaded succesfully') }}</x-success>
            @elseif (session('status') === 'image-deleted')
                <x-success>{{ __('Image deleted') }}</x-success>
            @endif

            <div class="overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (count($images) >= 1)

                        @foreach ($images as $key => $image)
                            <div class="card w-75 dark:bg-gray-800 text-light mb-5" style="margin: 0 auto;">

                                <div class="card-header px-5 py-3">
                                    <div class="d-flex justify-content-between align-items-center">

                                        <div class="d-flex align-items-center gap-3">
                                            @include('components.user-avatar', ['data' => $image->user->image, 'size' => 'width: 50px; height: 50px; border-radius: 100%;'])
                                            <p>{{$image->user->name}} {{$image->user->surname}}<span class="text-secondary"> | &#64;{{$image->user->nick}}</span></p>
                                        </div>

                                        @if ($image->user_id == \Auth::user()->id)
                                            <x-dropdown align="right" width="48">

                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150" style=" gap: 1rem;">
                                                        <img src="{{asset('img/light-ellipsis.png')}}" style="width: 35px; height: 35px;" alt="">
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('image.create', ['edit' => $image->id])">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>

                                                    <button type="button" class="btn text-danger px-4 py-2 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out w-100 text-left" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                        Delete
                                                    </button>
                                                </x-slot>

                                            </x-dropdown>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <a href="{{route('image.detail', ['id' => $image->id])}}"><img src="{{route('image.file', ['filename' => $image->image_path])}}"></a>
                                    <div class="px-5 py-4 d-flex justify-content-between align-items-center">

                                        <div class="card-text mb-0" style="width: 65%;">
                                            <span class="text-secondary">&#64;{{$image->user->nick}} | @if($image->created_at >= $image->updated_at) {{$image->created_at->diffForHumans(null, false, false, 1)}} @else {{$image->updated_at->diffForHumans(null, false, false, 1)}} @endif </span>
                                            <p class="mb-0">{{$image->description}}</p>
                                        </div>

                                        <div class="card-link d-flex gap-4">
                                            <div class="d-flex position-relative align-items-center gap-2">
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

                                                <div id="likes" data-id="likeCount-{{$key}}" class="d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                                    <span class="text-secondary">{{count($image->likes)}}</span>
                                                    <div>
                                                        @if (count($image->likes) >= 1)
                                                            <ul class="d-none rounded text-dark py-2 px-4">
                                                                @foreach ($image->likes as $like)
                                                                    <li class="d-flex align-items-center gap-1 mb-2 border-bottom pb-1">
                                                                        @include('components.user-avatar', ['data' => $like->user->image, 'size' => 'width: 30px; height: 30px; border-radius: 100%;'])
                                                                        <p>{{$like->user->name}} {{$like->user->surname}}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <a class="btn btn-warning fw-bold" href="{{route('image.detail', ['id' => $image->id])}}#comments">Comments <span>({{count($image->comments)}})</span></a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content dark:bg-gray-800">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="deleteModalLabel">Are you sure you want to delete this image?</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <p>Once you delete the image, it can not be recovered.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <a class="btn btn-danger" href="{{route('image.delete', ['id' => $image->id])}}">Delete</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                        @endforeach

                        <div class="clearfix"></div>
                        {{$images->links()}}
                    </div>

                    @else
                        <div class="text-center">
                            <h2 class="mb-4 fs-5">No uploaded images yet</h2>
                            <a class="btn btn-success" style="margin: 0 auto;" href="{{route('image.create')}}">Upload image</a>
                        </div>
                    @endif

            </div>
        </div>
    </div>
</x-app-layout>

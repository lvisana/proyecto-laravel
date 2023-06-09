<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Post By <span class="font-semibold">{{$image[0]->user->name}} {{$image[0]->user->surname}}</span>
        </h1>
    </x-slot>

    <section class="py-12">

        @if (session('status') === 'image-updated')
            <x-success>{{ __('Image updated succesfully') }}</x-success>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 card dark:bg-gray-800 text-light mb-5 @if (session('status') === 'image-updated') mt-3 @endif" style="margin-bottom: 0 !important;">

            <div class="card-header px-5 py-3">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-3">
                        @include('components.user-avatar', ['data' => $image[0]->user->image, 'size' => 'width: 50px; height: 50px; border-radius: 100%;'])
                        <p>{{$image[0]->user->name}} {{$image[0]->user->surname}}<span class="text-secondary"> | &#64;{{$image[0]->user->nick}}</span></p>
                    </div>

                    @if ($image[0]->user_id == \Auth::user()->id)
                        <x-dropdown align="right" width="48">

                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150" style=" gap: 1rem;">
                                    <img src="{{asset('img/light-ellipsis.png')}}" style="width: 35px; height: 35px;" alt="">
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('image.create', ['edit' => $image[0]->id])">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <x-dropdown-link class="text-danger" :href="route('image.delete', ['id' => $image[0]->id])">
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            </x-slot>

                        </x-dropdown>
                    @endif
                </div>
            </div>

            <div class="card-body p-0">
                <a href="{{route('image.detail', ['id' => $image[0]->id])}}"><img src="{{route('image.file', ['filename' => $image[0]->image_path])}}"></a>
                <div class="p-5">
                    <div class="mb-5 d-flex justify-content-between align-items-center">
                        <div class="card-text mb-0">
                            <span class="text-secondary">&#64;{{$image[0]->user->nick}} | @if($image[0]->created_at >= $image[0]->updated_at) {{$image[0]->created_at->diffForHumans(null, false, false, 1)}} @else {{$image[0]->updated_at->diffForHumans(null, false, false, 1)}} @endif</span>
                            <p class="mb-0">{{$image[0]->description}}</p>
                        </div>
                        <div class="card-link d-flex gap-4">
                            <div class="d-flex position-relative align-items-center gap-2">
                                @php  $is_like = false; @endphp

                                    @foreach ($image[0]->likes as $like)
                                        @if ($like->user_id === Auth::user()->id)
                                            @php  $is_like = true; @endphp
                                        @endif
                                    @endforeach

                                    @if($is_like) 
                                        <img class="like-btn btn-liked" id="{{$image[0]->id}}" style="width=25px; height: 25px;" src="{{asset('img/red-heart.png')}}" alt="">
                                    @else
                                        <img class="like-btn" id="{{$image[0]->id}}" style="width=25px; height: 25px;" src="{{asset('img/light-heart.png')}}" alt="">
                                    @endif

                                    <div id="likes" data-id="likeCount" class="d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                        <span class="text-secondary">{{count($image[0]->likes)}}</span>
                                        <div>
                                            @if (count($image[0]->likes) >= 1)
                                                <ul class="d-none rounded text-dark py-2 px-4">
                                                    @foreach ($image[0]->likes as $like)
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
                        </div>
                    </div>

                    <div id="comments">

                        @if (session('status') === 'comment-sent')
                            <x-success>{{ __('Comment sent') }}</x-success>
                        @elseif (session('status') === 'comment-deleted')
                            <x-success>{{ __('Comment deleted') }}</x-success>
                        @endif

                        <div class="mb-4">
                            <h2 class="fs-3 mb-4">Comments ({{count($image[0]->comments)}})</h2>
                            <hr class="w-100 mb-4">
                            <form action="{{route('comment.save')}}" method="POST">
                                @csrf
                                <input type="hidden" name="image_id" value="{{$image[0]->id}}">
                                <div><textarea class="w-100 bg-dark mb-3" name="content" id="content" cols="30" rows="3"></textarea></div>
                                @if($errors->has('content'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{$errors->firt('content')}} </strong>
                                    </span>
                                @endif
                                <input class="btn btn-success" style="background-color: #198754 !important;" type="submit" value="Submit">
                            </form>
                        </div>

                        <hr class="w-100 mb-4">

                        <div class="mb-4">
                            @foreach ($comments as $comment)
                                <div class="py-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="text-secondary">&#64;{{$comment->user->nick}} | {{$comment->created_at->diffForHumans(null, false, false, 1) }}</h3>
                                        <p>{{$comment->content}}</p>
                                    </div>
                                    @if ($comment->user_id === Auth::user()->id)
                                        <div>
                                            <a href="{{route('comment.delete', ['id' => $comment->id])}}"><img style="width: 15px;" src="{{asset('img/light-trash.png')}}" alt=""></a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="clearfix"></div>
                        {{$comments->links()}}

                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
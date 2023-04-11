<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Post By <span class="font-semibold">{{$image[0]->user->name}} {{$image[0]->user->surname}}</span>
        </h1>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 card text-bg-dark mb-5" style="margin-bottom: 0 !important;">

            <div class="card-header px-5 py-3 d-flex align-items-center gap-3">
                    @include('components.user-avatar', ['data' => $image[0]->user->image])
                <p>{{$image[0]->user->name}} {{$image[0]->user->surname}}<span class="text-secondary"> | &#64;{{$image[0]->user->nick}}</span></p>
            </div>

            <div class="card-body p-0">
                <a href="{{route('image.detail', ['id' => $image[0]->id])}}"><img src="{{route('image.file', ['filename' => $image[0]->image_path])}}"></a>
                <div class="p-5">
                    <div class="mb-5 d-flex justify-content-between align-items-center">
                        <div class="card-text mb-0">
                            <span class="text-secondary">&#64;{{$image[0]->user->nick}} | {{$image[0]->created_at->diffForHumans(null, false, false, 1) }}</span>
                            <p class="mb-0">{{$image[0]->description}}</p>
                        </div>
                        <div class="card-link d-flex gap-4">
                            <div class="d-flex align-items-center gap-2">
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

                                    <span class="text-secondary">{{count($image[0]->likes)}}</span>
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
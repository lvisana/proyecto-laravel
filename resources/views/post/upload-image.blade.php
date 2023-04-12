<x-app-layout>

        <x-slot name="header">
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Upload image') }}
            </h1>
        </x-slot>

        <section class="py-12 container text-light">
            <div class="row max-w-7xl justify-content-center p-4 sm:p-8 dark:bg-gray-800 shadow sm:rounded-lg mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="card-body">
                    <form method="POST" action=" {{route('image.save')}} " class="d-flex flex-column gap-3" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row align-items-center justify-content-center">
                            <label for="image_path" class="col-md-3 col-form-label text-right">Image</label>
                            <div class="col-md-7">
                                <input type="file" name="image_path" id="image_path" class="rounded border border-1 border-light form-control p-4 text-light" required>

                                @if($errors->has('image_path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{$errors->firt('image_path')}} </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row align-items-center justify-content-center">
                            <label for="description" class="col-md-3 col-form-label text-right">Description</label>
                            <div class="col-md-7">
                                <textarea type="file" name="description" id="description" class="rounded border border-1 border-light w-100 p-4 text-light" required></textarea>

                                @if($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{$errors->firt('description')}} </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <x-primary-button>{{ __('Upload') }}</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </section>

</x-app-layout>

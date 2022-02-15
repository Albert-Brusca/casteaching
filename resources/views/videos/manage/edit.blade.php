<x-casteaching-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edició del video') . ' ' . $video->title }}
        </h2>
    </x-slot>
    <div class="mx-auto sm:px-6 lg:px-8 w-full max-w-7xl">

        @can('videos_manage_create')

            <x-jet-form-section data-qa="form_video_edit">
                <x-slot name="title">
                    {{ __('Videos') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Informació bàsica del video') }}
                </x-slot>

                <x-slot name="actions">
                    <x-jet-button>
                        {{ __('Update') }}
                    </x-jet-button>
                </x-slot>

                <x-slot name="form">
                    @csrf
                    @method('PUT')
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="title" value="{{ __('Title') }}" />
                        <x-jet-input id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="name" required value="{{ $video->title }}"/>
                        <x-jet-input-error for="title" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <textarea required id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Description">{{ $video->description }}</textarea>
                        <x-jet-input-error for="description" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="url" value="{{ __('Url') }}" />

                        <div class="mt-1 flex rounded-md shadow-sm">
                                                          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                            http://
                                                          </span>
                            <input required type="url" name="url" id="url" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block  rounded-none rounded-r-md sm:text-sm border-gray-300" value="{{$video->url}}">
                        </div>
                        <x-jet-input-error for="url" class="mt-2" />
                    </div>
                </x-slot>
            </x-jet-form-section>

            <x-jet-section-border />


        @endcan

    </div>
</x-casteaching-layout>

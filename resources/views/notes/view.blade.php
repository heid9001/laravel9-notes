<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div x-data="Notes({
                        list:   '{{route('notes.paging')}}',
                        create: '{{route('notes.new')}}',
                        delete: '{{route('notes.delete', 0)}}',
                        update: '{{route('notes.update', 0)}}'
                    })" x-init="all()" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex justify-start">
                    <x-secondary-button @click="resetErrors(); reset(); $dispatch('open-modal', 'note-view')">{{__('New Note')}}</x-secondary-button>
                </div>
                <div class="flex flex-col justify-center mb-4 p-6 text-gray-900">
                    <template x-for="note in notes">
                        <div class="flex justify-center bg-white pb-4">
                            <div class="flex flex-row w-1/2 border border-gray-200 rounded-lg p-2">
                                <div class="w-1/2">
                                    <h5 x-text="note.shortTitle" class="mb-3 text-4xl font-bold tracking-tight" ></h5>
                                    <hr class="bg-gray-100 border-0 rounded dark:bg-gray-700"/>
                                    <p  x-text="note.shortContent" class="mb-3 font-normal"></p>
                                </div>
                                <div class="w-1/2 text-right">
                                    <i class="fa-solid fa-pen-to-square" @click="resetErrors(); choose(note.id); $dispatch('open-modal', 'note-update')"></i>
                                    <i class="fa-solid fa-trash" @click="resetErrors(); choose(note.id); $dispatch('open-modal', 'note-remove')"></i>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="p6 text-gray-900">
                    <nav aria-label="Pagination">
                        <ul class="flex justify-center mb-4">
                            <template x-for="link in links">
                                <li class="mr-2">
                                    <a  x-text="link.label"
                                        x-bind:href="link.url"
                                        x-on:click.prevent="navigate(link.label)"
                                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded"
                                    >
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <x-modal name="note-view">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <ul class="text-sm text-red-600 space-y-1">
                        <template x-for="error in errors">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                    <form @submit.prevent="create()">
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input name="title" x-model="title"/>
                        </div>
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <x-textarea name="content" x-model="content" />
                        </div>
                        <x-primary-button>{{__('Add')}}</x-primary-button>
                    </form>
                </div>
            </div>
        </x-modal>

        <x-modal name="note-remove">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <h2>Are you sure?</h2>
                    <x-secondary-button @click="remove(); $dispatch('close')">{{__('Yes')}}</x-secondary-button>
                    <x-secondary-button @click="$dispatch('close');">{{__('No')}}</x-secondary-button>
                </div>
            </div>
        </x-modal>

        <x-modal name="note-update">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <ul class="text-sm text-red-600 space-y-1">
                        <template x-for="error in errors">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                    <form @submit.prevent="update();">
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input name="title" x-model="title"/>
                        </div>
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <x-textarea name="content" x-model="content"></x-textarea>
                        </div>
                        <x-primary-button>{{__('Save')}}</x-primary-button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>

</x-app-layout>

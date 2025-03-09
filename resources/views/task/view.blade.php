<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task') }}
        </h2>
    </x-slot>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-lg font-medium text-gray-900">Pending Tasks</div>
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{route("task.view")}}" >
                        @csrf
                        <table class="table-auto" width="100%">
                            <thead>
                                <tr>
                                    <th class="border text-left p-8 p-4">Task</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <td>

                                    </td>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
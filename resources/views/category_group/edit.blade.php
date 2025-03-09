<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category group Setup') }}
        </h2>
    </x-slot>
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white">
            <form method="post" action="{{ route('category_group.update',$categoryGroup->id)}}" autocomplete="off">
                @csrf
                @method("PUT")
                <div class="overflow-hidden sm:rounded-lg p-5">
                    <div class="p-4">
                        <div class="p-2 font-bold">
                            Category name
                        </div>
                        <div>
                            <input type="text" name="category" class="w-full p-2 rounded-lg" value="{{ old('category',request('category',$categoryGroup["name"])) }}" placeholder="Category Name"/> 
                            @if($errors->has("category"))
                                <div class="font-bold text-red-100">{{ $errors("category")->first() }}</div>
                            @endif
                        </div>
                        <div class="p-2 font-bold">
                            Order
                        </div>
                        <div>
                            <input type="number" name="order" class="p-2 rounded-lg" value="{{ old('order',request('order',$categoryGroup["order"])) }}" placeholder="Order"/> 
                            @if($errors->has("order"))
                                <div class="font-bold text-red-100">{{ $errors("order")->first() }}</div>
                            @endif
                        </div>
                        <div class="p-2 font-bold">
                            <input type="radio" name="status" value="active" {{ old("status",$categoryGroup->status) == "active" ? "checked":""}}/>&nbsp;<b>ACTIVE</b>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="status" value="inactive" {{ old("status",$categoryGroup->status) == "inactive" ? "checked":""}}/>&nbsp;<b>INACTIVE</b>
                        </div>
                        <button class="mt-4 bg-black border-2 rounded-lg pt-1 pb-1 text-white w-40" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
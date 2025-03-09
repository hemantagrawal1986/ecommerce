@if(count($recommends)>0)
<div class="bg-white p-2 mt-4">
    <div class="text-lg p-4 font-bold">Trending Purchases</div>
    <div class="flex flex-row ">
        @foreach($recommends as $recommend)
          
            <div class="w-56">
                <a href="{{ route('item.info',$recommend->id) }}">
                    <img src="{{ asset('storage/'.$recommend->photo)}}" class="h-32 w-32 overflow-hidden">
                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-2">Rating {{ $recommend->rating }}</div>
                    <div  class="block mt-3 text-lg leading-tight font-medium text-black hover:underline after:content-['_↗']" >{{ $recommend->name }}</div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif
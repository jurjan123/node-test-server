<x-navbar></x-navbar>
<div class="grid grid-cols-3 w-5/6 gap-x-6 gap-y-14  ml-36 mt-20 ">
    @foreach($categories as $category)
<div class="border-4 border-indigo-500/100 rounded-md min-h-min flex-col items-center">
    <a href="{{route("categories.show", $category->title)}}"> <p class="bg-blue-500 text-center bg-opacity-95 text-white text-2xl pb-5 pt-5 hover:bg-blue-600">{{$category->title}}</p></a>
    <a href="{{route("categories.show",$category->title)}}" ><img @if($category->image != "preset.png") src="{{url("images/".$category->image)}}" class="min-w-full h-52  shadow hover:shadow-2xl transition-shadow transform hover:scale-95 cursor-pointer" @else src="{{url("preset.png")}}" class=" h-52 ml-24  max-h-fit" @endif ></a>
</div>
@endforeach
<div class="-mt-10 col-span-3">{{$categories->links()}}</div>
</div>

<script src="{{url("script.js")}}"></script>
</body>
</html>
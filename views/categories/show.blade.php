<x-navbar></x-navbar>

<div class="grid grid-cols-3 w-5/6 gap-x-6 gap-y-14  ml-36 mt-20 ">
    
    @foreach($products as $product)
<div class="border-2 border-black  col-span-2 rounded-md min-h-min flex ">
    <img @if($product->image != "preset.png") src="{{url("images/".$product->image)}}" class="h-60 w-56 shadow hover:shadow-2xl transition-shadow transform hover:scale-95 cursor-pointer" @else src="{{url("preset.png")}}" class="h-32 ml-24 w-56 max-h-fit" @endif >
    <div class="flex-col">
        <p class="text-xl pb-3 pt-5 ml-10 font-bold">{{$product->title}}</p>
        <p class="text-xl   ml-10">Borg: <i class="bi bi-currency-euro"></i>{{$product->warranty}}</p>
        <p class="text-xl  ml-10">Maximale uitleenduur:  {{date("d/m/y", strtotime($product->max_lease))}}</p>
        <p class="text-lg pr-5 pb-5 pt-5 ml-10 ">{{$product->description}}</p>
        <form action="{{route("cart.add", $product->id)}}" method="post">
            @csrf
            <button class="bg-light-green-rgb hover:bg-green-400 p-2 mb-3 rounded-md ml-96" id="openModalBtn">Product toevoegen</button>
            
                
            
        </form>
    </div>
</div>
@endforeach

    <div class=" border-2 absolute top-32 -z-10 right-28   mt-10 w-96 h-96  border-black rounded-md">
        <p>hello qole</p>
    </div>
    </div>
            



<script src="{{url("script.js")}}"></script>
</body>
</html>
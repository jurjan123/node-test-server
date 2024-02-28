<x-navbar></x-navbar>
<div class="grid grid-cols-5 min-h-screen gap-x-6 h-2/3  ml-36 mt-20 ">
<x-side-bar></x-side-bar>
<div class="shadow-md rounded-lg overflow-hidden flex flex-col gap-x  p-7 bg-gray-100 col-span-4 leading-10 w-4/6 min-h-fit">
    <form action="{{route("admin.products.store")}}" method="post" enctype="multipart/form-data">
        @csrf
       
    <div>
        <p>Titel</p>
        <input type="text" class="rounded-md w-11/12 mb-5 pl-2 @error("title") border-2 border-red-500 @enderror" name="title" value="{{old("title")}}">
        @error("title")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    <div>
        <p>beschrijving </p>
        <textarea class="rounded-md mb-5 pl-2 w-11/12 @error("description") border-2 border-red-500 @enderror" id="editor" name="description"  id="container" rows="20">{{old("description")}}</textarea>
        @error("description")
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    </div>
    <div class="mt-3">
        <p>Afbeelding</p>
        <input id="image" name="image" value="{{old("image")}}" placeholder="Afbeelding kiezen" type="file" class="rounded-md mb-5  w-6/12 @error("image") border-2 border-red-500 @enderror"  autofocus autocomplete="name" />
        @error("user_image")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    <div>
        <p>Maximale leenduur</p>
        <!--<input for="image" :value="__('Kies datum')" />-->
        <input type="date" class="rounded-md mb-5 pl-2 p-1  w-6/12 @error("max_lease") border-2 border-red-500 @enderror"
        name="max_lease" step="any" value="{{old("max_lease")}}">
       
        @error("max_lease")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    
    <div>
        <p>Garantie </p>
        <input type="text" class="rounded-md mb-5 pl-2 w-11/12 @error("warranty") border-2 border-red-500 @enderror" name="warranty" value="{{old("warranty")}}" >
        @error("warranty")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>

    <div class="mb-3 mt-3 w-11/12 d-column">
        <label for="formFile"  class="form-label">Kies categorie </label>
        <div class="mt-1">

        <select class="p-2  items-center rounded-md w-40 " name="category_id">
            <option value="">kies categorie</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
        </select>
       
        </div>
       
    </div>

    
    <div>
        <p>Barcode nummer</p>
        <input type="text" name="barcode_number" class="rounded-md mb-5 pl-2  w-11/12" >
        @error("barcode_number")
        <p class="text-red-500 text-xs -mt-3  ">{{$message}}</p>
        @enderror
    </div>
    <div class=" w-11/12  flex justify-end">
        
        <a href="{{route("admin.users.index")}}" class="text-lg mt-1">Annuleren</a>
        <input type="submit" value="Opslaan" class="rounded-md ml-3  text-white cursor-pointer bg-blue-500 mb-3 hover:bg-blue-600   w-1/6" >
        
    </div>
    </form>

</div>
@include("includes.ckeditor")
<script src="{{url("script.js")}}"></script>
</body>

</html>
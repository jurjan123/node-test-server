<x-navbar></x-navbar>
<div class="grid grid-cols-5 min-h-screen gap-x-6 h-2/3  ml-36 mt-20 ">
<x-side-bar></x-side-bar>
<div class="shadow-md rounded-lg overflow-hidden flex flex-col gap-x  p-7 bg-gray-100 col-span-4 leading-10 w-4/6 min-h-fit">
    <form action="{{route("admin.categories.update", $category)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method("PUT")
    <div>
        <p>Titel</p>
        <input type="text" class="rounded-md w-11/12 mb-5 pl-2 @error("title") border-2 border-red-500 @enderror" name="title" value="{{old("title", $category->title)}}">
        @error("title")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    <div>
        <p>beschrijving </p>
        <textarea class="rounded-md mb-5 pl-2 w-11/12 @error("description") border-2 border-red-500 @enderror" id="editor" name="description"  id="container" rows="20">{{old("description", $category->description)}}</textarea>
        @error("description")
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    </div>
    <div class="mt-3">
        <p>Afbeelding</p>
        <input id="image" name="image" value="{{old("image", $category->image)}}" placeholder="Afbeelding kiezen" type="file" class="rounded-md mb-5  w-6/12 @error("image") border-2 border-red-500 @enderror"  autofocus autocomplete="name" />
        @error("image")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
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
<div class="bg-gray-100  text-black h-64 col-span-1 row-span-3  text-xl">

    <div class="flex justify-center border-solid h-16  cursor-pointer border-2 pt-4 @if(Route::is("admin.categories.index")) bg-gray-50 @endif hover:bg-gray-50">
        <a href="{{route("admin.categories.index")}}"  class="flex min-w-full pl-10 gap-2"><i class="bi bi-tag-fill"></i><p class="">Categorieen</p></a>  
    </div>

    <div class="flex justify-center h-16  border-solid cursor-pointer border-2 pt-4  @if(Route::is("admin.users.index")) bg-gray-50 @endif hover:bg-gray-50">
        <a href="{{route("admin.users.index")}}" class="flex min-w-full pl-10  gap-2 "><i class="bi bi-person-fill"></i><p class="">Gebruikers</p></a>
    </div>
   
    
    <div class="flex justify-center border-solid h-16  cursor-pointer border-2 pt-4 hover:bg-gray-50 @if(Route::is("admin.products.index")) bg-gray-50 @endif hover:bg-gray-50 ">
        <a href="{{route("admin.products.index")}}" class="flex min-w-full pl-10 gap-2"><i class="bi bi-bag "></i><p class="">Producten</p></a>
    </div>
    
    
    <div class="flex justify-center border-solid h-16   cursor-pointer border-2 pt-4 hover:bg-gray-50">
        <a href="" class="flex gap-2 min-w-full pl-10"> <i class="bi bi-book text-black"></i><p class="">Reserveringen</p></a>
       
    </div>
   
</div>


<x-navbar></x-navbar>

    <div class="grid grid-cols-5 w-5/6 gap-x-6  ml-36 mt-28 ">
      <x-side-bar></x-side-bar>
      <div class="col-span-4 flex  justify-end" id="searchbar">
        <a href="{{route("admin.categories.create")}}" class=" -mt-16"><button class="bg-blue-500 hover:bg-blue-600 rounded-md h-12 w-40 text-white">Categorie aanmaken</button></a>
      </div>
      
          <div class="shadow-lg rounded-lg overflow-hidden col-span-4">
           
              <table class="min-w-full  divide-y divide-gray-200 ">
                <thead class="">
                  <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Titel</th>
                    <th class="px-16 py-3 bg-gray-50 text-center  text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Afbeelding</th>
                    <th class="px-6 py-3 bg-gray-50 text-left  leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($categories as $category)
                  <tr>
                    <td class="px-6 py-4 whitespace-no-wrap">
                      <div class="flex items-center">
                        
                        <div >
                        <div class="text-sm text-left leading-5 font-medium text-gray-900">{{$category->title}}</div>
                        </div>
                      </div>
                      </td>
                      <td class=" py-4 whitespace-no-wrap">
                        <div class="text-sm leading-5 flex justify-center text-gray-900">
                            <img @if($category->image != "preset.png") src="{{url("images/".$category->image)}}" @else src="{{url("preset.png")}}" @endif class="h-16 w-24 ">
                        </div>
                      </td>
                      <td class=" py-4 whitespace-no-wrap">
                        <div class="text-sm leading-5 text-gray-900">
                            
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                       
                      </td>
                      <td class="px-6 py-4  text-xl justify-between leading-5 font-medium">
                        
                        <a href="{{route("admin.categories.edit", $category)}}">
                          <button type="submit" role="button">
                            <i class="bi bi-pen text-indigo-600   hover:text-indigo-900"></i>
                            </button>
                        
                        </a>
                        
                         <form action="{{route("admin.categories.delete", $category)}}" method="POST" class="inline-flex" >
                          @csrf @method("delete")
                          <button type="submit" role="button" onclick="return confirm('Weet je zeker dat je wilt verwijderen?')">
                          <i class="bi bi-trash ml-2 cursor-pointer text-red-600 hover:text-indigo-900" ></i>
                          </button>
                         </form> 
                        
                      
                      </td>
                      
                    </tr>
                    @endforeach
                   
                  </tbody>
                  
                </table>
                
                <div class="p-4 ">{{$categories->links()}}</div>
              </div>
        
    </div>
    <script src="{{url("script.js")}}"></script>
</body>
</html>



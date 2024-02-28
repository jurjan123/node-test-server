<x-navbar></x-navbar>

    <div class="grid grid-cols-5 w-5/6 gap-x-6  ml-36 mt-28 ">
      <x-side-bar></x-side-bar>
      <div class="col-span-4 flex  justify-end" id="searchbar">
        <a href="{{route("admin.users.create")}}" class=" -mt-16"><button class="bg-blue-500 hover:bg-blue-600 rounded-md h-12 w-40 text-white">Gebruiker aanmaken</button></a>
      </div>
      
          <div class="shadow-lg rounded-lg overflow-hidden col-span-4">
           
              <table class="min-w-full  divide-y divide-gray-200 ">
                <thead>
                  <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Volledige naam</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Telefoonnummer</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($users as $user)
                  <tr>
                    <td class="px-6 py-4 whitespace-no-wrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <img class="h-10 w-10 rounded-full" @if($user->user_image != "preset.png") src="" @else src="{{url("preset.png")}}" @endif alt="User image">
                          </div>
                        <div class="ml-4">
                        <div class="text-sm leading-5 font-medium text-gray-900">{{$user->first_name}} {{$user->preposition}} {{$user->last_name}}</div>
                        </div>
                      </div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        <div class="text-sm leading-5 text-gray-900">{{$user->email}}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        <div class="text-sm leading-5 text-gray-900">{{$user->phone_number}}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold bg-green-100 text-green-800">
                          Gebruiker
                        </span>
                      </td>
                      <td class="px-6 py-4  text-xl justify-between leading-5 font-medium">
                        <form action="{{route("admin.users.edit", $user)}}" method="post" class="inline-flex"> 
                          @csrf
                          <button type="submit" role="button">
                          <i class="bi bi-pen text-indigo-600   hover:text-indigo-900"></i>
                          </button>
                        </form>
                          
                         <form action="{{route("admin.users.delete", $user)}}" method="POST" class="inline-flex" >
                          @csrf @method("delete")
                          <button type="submit" role="button" onclick="return confirm('Weet je zeker dat je {{ $user->first_name }} wilt verwijderen?')">
                          <i class="bi bi-trash ml-2 cursor-pointer text-red-600 hover:text-indigo-900" ></i>
                          </button>
                         </form> 
                        
                      
                      </td>
                      
                    </tr>
                    @endforeach
                   
                  </tbody>
                </table>
                <div class="p-4 ">{{ $users->links()}}</div>
              </div>
        
    </div>
    <script src="{{url("script.js")}}"></script>
</body>
</html>



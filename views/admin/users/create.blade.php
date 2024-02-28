<x-navbar></x-navbar>
<div class="grid grid-cols-5 min-h-screen gap-x-6 h-2/3  ml-36 mt-20 ">
<x-side-bar></x-side-bar>
<div class="shadow-md rounded-lg overflow-hidden flex flex-col gap-x  p-7 bg-gray-100 col-span-4 leading-10 w-4/6 min-h-fit">
    <form action="{{route("admin.users.store")}}" method="post">
        @csrf
       
    <div>
        <p>Voornaam</p>
        <input type="text" class="rounded-md w-11/12 mb-5 pl-2" name="first_name" value="{{old("first_name")}}">
        @error("first_name")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    <div>
        <p>Tussenvoegsel </p>
        <input type="text" class="rounded-md mb-5 pl-2 w-11/12" name="preposition"  value="{{old("preposition")}}">
        @error("preposition")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    <div>
        <p>Achternaam</p>
        <input type="text" class="rounded-md mb-5 pl-2 w-11/12" name="last_name"  value="{{old("last_name")}}">
        @error("last_name")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    <div>
        <p>Email</p>
        <input type="email" class="rounded-md mb-5 pl-2  w-11/12" name="email"  value="{{old("email")}}">
        @error("email")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    
    <div>
        <p>Wachtwoord </p>
        <input type="password" class="rounded-md mb-5 pl-2 w-11/12" name="password" >
        @error("password")
        <p class="text-red-500 text-xs -mt-3">{{$message}}</p>
        @enderror
    </div>
    <div>
        <p>Wachtwoord Herhalen</p>
        <input type="password" name="password_confirmation" class="rounded-md mb-5 pl-2  w-11/12" >
        @error("password_confirmation")
        <p class="text-red-500 text-xs -mt-3  ">{{$message}}</p>
        @enderror
    </div>
    <div class=" w-11/12  flex justify-end">
        
        <a href="{{route("admin.users.index")}}" class="text-lg mt-1">Annuleren</a>
        <input type="submit" value="Opslaan" class="rounded-md ml-3  text-white cursor-pointer bg-blue-500 mb-3 hover:bg-blue-600   w-1/6" >
        
    </div>
    </form>

   
   
    

</div>
<script src="{{url("script.js")}}"></script>
</body>

</html>
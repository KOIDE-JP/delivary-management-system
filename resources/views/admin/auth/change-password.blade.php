@extends('backend.layout.app')
@section('title')
    Change Password
@endsection
@section('main')

 <div class="py-5 align-middle inline-block min-w-full sm:px-6 lg:px-8">

    <form action="{{route('change.password.process')}}" method="post" class="bg-white px-4 py-3 rounded-lg space-y-7 shadow-md">
        @csrf
        <div>
            <label for="name" class="block text-sm leading-5 font-medium text-gray-700">Old Password<span class="text-red-600">*</span></label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input id="name" value="{{old('old_password')}}" name="old_password" type="password"
                       class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:ring-2 focus:border-blue-200 focus:outline-none"
                        placeholder="Enter your old password"/>
            </div>
            @error('old_password')<span class="text-red-600">{{$message}}</span>@enderror
        </div>


        <div>
            <label for="dob" class="block text-sm font-medium leading-5 text-gray-700">New Password<span class="text-red-600">*</span></label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input id="dob" name="password" type="password"
                       value="{{old('password')}}" placeholder="Enter your new password"
                       class="form-control block w-full px-3  py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                       rounded transition ease-in-out m-0 focus:text-gray-700 focus:ring-2 focus:border-blue-200 focus:outline-none"/>
                @error('password')<span class="text-red-600">{{$message}}</span>@enderror
            </div>
        </div>

        <div>
            <label for="dob" class="block text-sm font-medium leading-5 text-gray-700">Confirm Password<span class="text-red-600">*</span></label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input id="dob" name="password_confirmation" type="password"
                       value="{{old('password_confirmation')}}" placeholder="Enter your confirm password"
                       class="form-control
                        block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:ring-2 focus:border-blue-200 focus:outline-none"/>
                @error('password_confirmation')<span class="text-red-600">{{$message}}</span>@enderror
            </div>
        </div>
       
                
        <div class="mt-8 pt-5">
            <div class="flex justify-end">
            
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    Save
                    </button>
                </span>
            </div>
        </div>
          
         
    </form>

</div>

@stop

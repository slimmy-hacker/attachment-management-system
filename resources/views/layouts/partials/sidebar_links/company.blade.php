{{-- Company Portal --}}
<li class="mt-4">
    <span class="text-gray-400 px-2 text-sm">Company Portal</span>
</li>


<li>
    <a href="{{ route('opportunities.index') }}"
       class="text-base text-white font-normal rounded-lg hover:bg-gray-100 hover:text-gray-900 flex items-center p-2 group">
        <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
             fill="currentColor" viewBox="0 0 20 20">
             <path d="M4 3h12v2H4zM4 7h12v2H4zM4 11h12v2H4zM4 15h12v2H4z"></path>
        </svg>
        <span class="ml-3 flex-1 whitespace-nowrap">Opportunities</span>
    </a>
</li>




<li>
    <a href="{{ route('company.is.index') }}"
       class="text-base text-white font-normal rounded-lg hover:bg-gray-100 hover:text-gray-900 flex items-center p-2 group">
        <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
             fill="currentColor" viewBox="0 0 20 20">
             <path d="M10 3a3 3 0 110 6 3 3 0 010-6zM2 16a6 6 0 1116 0H2z"></path>
        </svg>
        <span class="ml-3 flex-1 whitespace-nowrap">Supervisors</span>
    </a>
</li>

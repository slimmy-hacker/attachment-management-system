{{-- Company Portal --}}
<li class="mt-4">
    <span class="text-gray-400 px-2 text-sm">Company Portal</span>
</li>

<li>
    <a href="{{ route('company.portal') }}"
       class="text-base text-white font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 hover:text-gray-900 group">
        <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
             fill="currentColor" viewBox="0 0 20 20">
             <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
             <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
        </svg>
        <span class="ml-3">Dashboard</span>
    </a>
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
    <a href="{{ route('company.documents') }}"
       class="text-base text-white font-normal rounded-lg hover:bg-gray-100 hover:text-gray-900 flex items-center p-2 group">
        <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
             fill="currentColor" viewBox="0 0 20 20">
             <path d="M6 2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z"></path>
        </svg>
        <span class="ml-3 flex-1 whitespace-nowrap">Documents</span>
    </a>
</li>

<li>
    <a href="{{ route('company.reports') }}"
       class="text-base text-white font-normal rounded-lg hover:bg-gray-100 hover:text-gray-900 flex items-center p-2 group">
        <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
             fill="currentColor" viewBox="0 0 20 20">
             <path d="M9 2a7 7 0 00-7 7v1h14V9a7 7 0 00-7-7zM4 12h12l-1.5 6h-9z"></path>
        </svg>
        <span class="ml-3 flex-1 whitespace-nowrap">Reports</span>
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

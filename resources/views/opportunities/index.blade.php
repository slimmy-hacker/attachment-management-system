@extends('layouts.my_app')

@section('content')
<div class="w-full min-h-screen bg-gray-50/50 p-4 lg:p-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Opportunities Hub</h1>
            <p class="text-gray-500 font-medium">Connect with the next generation of talent from DeKUT.</p>
        </div>
        @if($isCompany)
            <button id="btn-post" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-bold shadow-xl shadow-indigo-200 transition-all transform hover:-translate-y-1 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                ADVERTISE POSITION
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="text-gray-400 text-xs font-bold uppercase mb-1">Visibility</div>
            <div class="text-2xl font-black text-indigo-600">Public</div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="text-gray-400 text-xs font-bold uppercase mb-1">Target Audience</div>
            <div class="text-2xl font-black text-gray-800">DeKUT Students</div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="text-gray-400 text-xs font-bold uppercase mb-1">Platform Status</div>
            <div class="text-2xl font-black text-green-500 flex items-center">
                <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span> Verified
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Recent Postings</h3>
        </div>
        <div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Available Opportunities</h3>
    <div id="search-wrapper"></div> 
</div>

<table id="opp_table" class="hidden">
    <thead>
        <tr>
            <th>Title</th>
            <th>Location</th>
            <th>Date</th>
             <th>Description</th>
            <th>Company</th>
          
        </tr>
    </thead>
</table>

<div id="opportunity-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    </div>
    </div>
</div>

<div id="modal-post" class="fixed inset-0 z-50 hidden bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl p-10 relative">
        <button id="close-modal" class="absolute top-8 right-8 text-gray-300 hover:text-gray-600 text-2xl">&times;</button>
        
        <div class="text-center mb-8">
            <div class="bg-indigo-100 text-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-bullhorn text-2xl"></i>
            </div> 
            <h2 class="text-2xl font-black text-gray-900">New Advertisement</h2>
            <p class="text-gray-500 text-sm">Define the role and find your next intern.</p>
        </div>
<form id="postForm" class="space-y-5">
    @csrf
    
    <div>
        <label for="title" class="block mb-2 text-sm font-bold text-gray-700">Job Title</label>
        <input type="text" id="title" name="title" placeholder="e.g. Graphic Design Intern" 
            class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-semibold" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="location" class="block mb-2 text-sm font-bold text-gray-700">Location</label>
            <input type="text" id="location" name="location" placeholder="City / Town" 
                class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-semibold" required>
        </div>
        <div>
    <label for="expiry_date" class="block mb-2 text-sm font-bold text-gray-700">Expiry Date</label>
    <input type="date" 
           id="expiry_date" 
           name="expiry_date" 
           min="{{ now()->addDay()->format('Y-m-d') }}" 
           max="{{ now()->addDays(90)->format('Y-m-d') }}"
           class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-semibold text-gray-600" 
           required>
    <p class="text-xs text-gray-400 mt-1 italic">* Must be at least 24 hours from now.</p>
</div>
    </div>

    <div>
        <label for="description" class="block mb-2 text-sm font-bold text-gray-700">Job Description</label>
        <textarea id="description" name="description" rows="4" placeholder="Briefly describe the responsibilities..." 
            class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-semibold" required></textarea>
    </div>

    <div>
        <label for="link" class="block mb-2 text-sm font-bold text-gray-700">Application Link</label>
        <input type="url" id="link" name="link" placeholder="https://example.com/apply" 
            class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-semibold" required>
    </div>

    <button type="submit" id="saveBtn" class="w-full bg-gray-900 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-black transition-all">
        LAUNCH POSTING
    </button>
</form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const isStudent = @json(Auth::user()->role === 'student');
    $(document).ready(function() {
    $('#btn-post').click(() => $('#modal-post').removeClass('hidden'));
    $('#close-modal').click(() => $('#modal-post').addClass('hidden'));

    let table = $('#opp_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('opportunities.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'location', name: 'location'},
            {data: 'expiry_date', name: 'expiry_date'},
            {data: 'description', name: 'description'},
            {data: 'company_name', name: 'company_name'}, 
           {data: 'link', name: 'link', visible: false},
        ],
        dom: 'f', 
        language: { search: "", searchPlaceholder: "Search opportunities..." },
        initComplete: function() {
            
            $('.dataTables_filter').detach().appendTo('#search-wrapper');
            $('.dataTables_filter input').addClass('bg-gray-50 border-none rounded-2xl px-6 py-3 w-64 focus:ring-2 focus:ring-indigo-500 font-semibold text-sm');
        },
        drawCallback: function(settings) {
            let api = this.api();
            let rows = api.rows({ page: 'current' }).data();
            let grid = $('#opportunity-grid');
            grid.empty();

            if (rows.length === 0) {
                grid.append('<div class="col-span-full text-center py-12 text-gray-400 font-bold uppercase tracking-widest text-xs">No opportunities found</div>');
                return;
            }

            rows.each(function(data) {
                
                let expiryDate = new Date(data.expiry_date);
                let isExpired = expiryDate < new Date();
                let stateText = isExpired ? 'State: Closed' : 'State: Active';
                let stateClass = isExpired ? 'text-red-500' : 'text-green-500';
                let applyButton = '';
    if (isStudent && !isExpired) {
        if (data.link) {
            applyButton = `
                <a href="${data.link}" target="_blank" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition-all">
                   Apply
                </a>`;
        } else {
            applyButton = `
                <button disabled class="bg-gray-400 text-white px-4 py-2 rounded-xl text-xs font-bold cursor-not-allowed">
                    Apply
                </button>`;
        }
    }
                 let cardHtml = `
                    <div class="bg-white p-6 rounded-[1.8rem] border-2 border-gray-100 hover:border-indigo-400 transition-all duration-300 shadow-sm flex flex-col justify-between group">
                        <div>
                            <h3 class="text-lg font-black text-gray-800 leading-tight mb-2 group-hover:text-indigo-600 transition-colors capitalize">
                                ${data.title}
                            </h3>
                            <p class="text-indigo-500 font-bold text-[10px] uppercase tracking-widest mb-4">
                                ${data.company_name}
                            </p>
                             <p class="text-indigo-500 font-bold text-[10px] uppercase tracking-widest mb-4">
                                ${data.description}
                            </p>
                            <p class="text-gray-400 text-xs font-semibold">
                                ${data.location} — ${data.expiry_date}
                            </p>
                        </div>

                        
    <span class="text-[10px] font-black uppercase tracking-widest ${stateClass}">
        ${stateText}
    </span>
    ${applyButton}
</div>

                        </div>
                    </div>
                `;
                grid.append(cardHtml);
            });
        }
    });

    
    $('#postForm').on('submit', function(e) {
        e.preventDefault();
        $('#saveBtn').prop('disabled', true).text('Launching...');
        $.ajax({
            url: "{{ route('opportunities.store') }}",
            method: "POST",
            data: new FormData(this),
            processData: false, 
            contentType: false,
            success: function() {
                $('#modal-post').addClass('hidden');
                $('#postForm')[0].reset();
                table.ajax.reload();
                Swal.fire({ icon: 'success', title: 'Live!', text: 'Your ad is now visible to students.', padding: '3rem', borderRadius: '2rem' });
            },
            
            error: () => Swal.fire('Error', 'Please check your inputs.', 'error'),
            complete: () => $('#saveBtn').prop('disabled', false).text('LAUNCH POSTING')
        });
    });
});
</script>
@endsection
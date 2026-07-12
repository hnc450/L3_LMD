@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
</div>
@endif
@if(session('info'))
<div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
    <i class="fa-solid fa-circle-info"></i> {{ session('info') }}
</div>
@endif
@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4">
    <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

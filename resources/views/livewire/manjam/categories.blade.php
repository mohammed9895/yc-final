<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-20 gap-3">
        @foreach($talent_types as $type)
            <a href="/manjam/categories/{{ $type->id }}"
               class="block bg-white p-5 flex items-center hover:shadow-lg hover:cursor-pointer">
                <div class="bg-[#cab5f4] p-8">
                    <x-icon name="{{ $type->icon }}" class="w-10 h-10 text-[#684e9a]"/>
                </div>
                <div class="ml-4 rtl:mr-4">
                    <h1 class="text-2xl text-slate-800 font-bold"> {{ $type->name }}</h1>
                    <p class="text-slate-500">{{ $type->talents_count }}+ {{ __('Talent Registered') }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>

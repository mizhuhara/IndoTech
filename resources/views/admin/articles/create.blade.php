@extends('admin.layouts.app')

@section('title', 'Create Article — Admin')

@section('content')
{{-- Breadcrumb --}}
<nav class="text-[13px] text-slate-500 mb-4">
    <span class="hover:text-blue-600 cursor-pointer">Home</span>
    <span class="mx-1.5">›</span>
    <a href="{{ route('admin.articles.index') }}" class="hover:text-blue-600 cursor-pointer">Articles</a>
    <span class="mx-1.5">›</span>
    <span class="text-slate-900 font-medium">Create Article</span>
</nav>

{{-- Header + actions --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-[24px] font-bold text-slate-900">Create Article</h1>
        <p class="text-[13.5px] text-slate-500 mt-0.5">Write and publish a new article</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center h-10 px-4 rounded-lg border border-slate-200 bg-white text-slate-600 text-[13.5px] font-semibold hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit" form="article-form" class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-[#0b57d0] text-white text-[13.5px] font-semibold hover:bg-blue-700 shadow-sm transition">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 4h11l3 3v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm3 0v5h8V4M7 15h10m-10 4h10"/></svg>
            Save Article
        </button>
    </div>
</div>

<form id="article-form" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== LEFT: Main form ===== --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Article Title --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label for="title" class="block text-[13.5px] font-semibold text-slate-800 mb-2">
                    Article Title <span class="text-red-500">*</span>
                </label>
                <input id="title" name="title" type="text" required placeholder="Enter article title"
                       oninput="autoSlug(this.value)"
                       class="w-full h-11 px-3.5 rounded-lg border border-slate-300 text-[14px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">

                {{-- Slug --}}
                <label for="slug" class="block text-[13.5px] font-semibold text-slate-800 mt-5 mb-2">Slug</label>
                <div class="flex items-center h-11 rounded-lg border border-slate-300 bg-white overflow-hidden focus-within:border-[#0b57d0] focus-within:ring-2 focus-within:ring-blue-500/20 transition">
                    <span class="h-full px-3.5 flex items-center text-[13px] text-slate-400 bg-slate-50 border-r border-slate-200 whitespace-nowrap">indotech.com/blog/</span>
                    <input id="slug" name="slug" type="text" placeholder="article-slug"
                           class="h-full flex-1 min-w-0 px-3.5 text-[14px] text-slate-900 placeholder-slate-400 outline-none bg-transparent">
                </div>
                <p class="text-[12px] text-slate-400 mt-1.5">Auto-generated from title. You can change it.</p>
            </div>

            {{-- Content / Rich text editor --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 pt-5 pb-3">
                    <label class="block text-[13.5px] font-semibold text-slate-800 mb-2">Content</label>
                </div>
                <div class="border-t border-slate-200">
                    {{-- Toolbar --}}
                    <div class="flex items-center gap-1 px-3 py-2 border-b border-slate-200 bg-slate-50/50">
                        <button type="button" class="w-8 h-8 rounded-md text-slate-600 font-bold text-[15px] hover:bg-slate-200/70 transition" title="Bold"><b>B</b></button>
                        <button type="button" class="w-8 h-8 rounded-md text-slate-600 font-serif italic text-[15px] hover:bg-slate-200/70 transition" title="Italic"><i>I</i></button>
                        <button type="button" class="w-8 h-8 rounded-md text-slate-600 underline text-[15px] hover:bg-slate-200/70 transition" title="Underline"><u>U</u></button>
                        <div class="w-px h-5 bg-slate-200 mx-1"></div>
                        <button type="button" class="w-8 h-8 rounded-md text-slate-600 text-[15px] hover:bg-slate-200/70 transition" title="Bullet list">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 6h12M9 12h12M9 18h12M4 6h.01M4 12h.01M4 18h.01"/></svg>
                        </button>
                        <button type="button" class="w-8 h-8 rounded-md text-slate-600 text-[15px] hover:bg-slate-200/70 transition" title="Numbered list">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M10 6h11M10 12h11M10 18h11M4 6h1v4M4 10h2M6 14v4"/></svg>
                        </button>
                        <div class="w-px h-5 bg-slate-200 mx-1"></div>
                        <button type="button" class="w-8 h-8 rounded-md text-slate-600 text-[15px] hover:bg-slate-200/70 transition" title="Link">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5 21 3m-8.5 7.5L16 7a4.95 4.95 0 0 1 7 7l-3 3a4.95 4.95 0 0 1-7 0M10.5 13.5 3 21m8.5-7.5L8 17a4.95 4.95 0 0 1-7-7l3-3a4.95 4.95 0 0 1 7 0"/></svg>
                        </button>
                        <button type="button" class="w-8 h-8 rounded-md text-slate-600 text-[15px] hover:bg-slate-200/70 transition" title="Image">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="m4 17 5-5 4 4 3-3 4 4"/></svg>
                        </button>
                    </div>
                    {{-- Editor area --}}
                    <textarea id="content" name="content" rows="12" placeholder="Write your article content here..."
                              class="w-full px-5 py-4 text-[14px] text-slate-800 leading-relaxed placeholder-slate-400 outline-none bg-white resize-y min-h-[280px]"></textarea>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT: Sidebar panel ===== --}}
        <div class="space-y-6">

            {{-- Publish Status --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label for="status" class="block text-[13.5px] font-semibold text-slate-800 mb-2">Publish Status</label>
                <div class="relative">
                    <select id="status" name="status"
                            class="w-full h-11 px-3.5 pr-9 rounded-lg border border-slate-300 bg-white text-[14px] text-slate-900 appearance-none outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                        <option>Published</option>
                        <option>Draft</option>
                        <option>Archived</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m8 10 4 4 4-4"/></svg>
                </div>
                <p class="text-[12px] text-slate-400 mt-2">Last edited: Today, 10:42 AM</p>
            </div>

            {{-- Category --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label for="category" class="block text-[13.5px] font-semibold text-slate-800 mb-2">Category</label>
                <div class="relative">
                    <select id="category" name="category"
                            class="w-full h-11 px-3.5 pr-9 rounded-lg border border-slate-300 bg-white text-[14px] text-slate-900 appearance-none outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                        <option>Technology</option>
                        <option selected>Education</option>
                        <option>Career</option>
                        <option>News</option>
                        <option>Press Release</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m8 10 4 4 4-4"/></svg>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label class="block text-[13.5px] font-semibold text-slate-800 mb-3">Featured Image</label>
                <label for="featured_image" class="block cursor-pointer">
                    <div class="border-2 border-dashed border-slate-300 rounded-xl bg-slate-50 flex flex-col items-center justify-center aspect-[16/9] overflow-hidden relative group">
                        {{-- Placeholder --}}
                        <img id="img-preview" class="absolute inset-0 w-full h-full object-cover hidden" alt="Preview">
                        <div id="img-placeholder" class="text-center">
                            <svg class="mx-auto text-slate-400" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="m4 17 5-5 4 4 3-3 4 4"/></svg>
                            <p class="mt-2 text-[13px] font-medium text-slate-500 group-hover:text-[#0b57d0]">Click to upload image</p>
                        </div>
                        <span id="img-replace" class="absolute inset-0 bg-black/50 hidden items-center justify-center text-white text-[13px] font-semibold">Click to replace image</span>
                    </div>
                    <input id="featured_image" name="featured_image" type="file" accept="image/*" class="hidden" onchange="previewImage(this)">
                </label>
                <p class="text-[12px] text-slate-400 mt-2">SVG, PNG, JPG or GIF. Max. 5MB</p>
            </div>

            {{-- Meta & SEO --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
                <h3 class="text-[14px] font-bold text-slate-800">Meta & SEO</h3>
                <div>
                    <label for="tags" class="block text-[13px] font-semibold text-slate-700 mb-2">Tags (comma separated)</label>
                    <input id="tags" name="tags" type="text" value="EdTech, Indonesia, AI, Future"
                           class="w-full h-10 px-3.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label for="meta_description" class="block text-[13px] font-semibold text-slate-700 mb-2">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" placeholder="Short meta description for SEO"
                              class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20 resize-none"></textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function autoSlug(value) {
        const slug = document.getElementById('slug');
        if (!slug.value || slug.dataset.touched !== 'true') {
            slug.value = value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/[\s_]+/g, '-')
                .replace(/-+/g, '-');
        }
    }
    document.getElementById('slug').addEventListener('input', function () {
        this.dataset.touched = 'true';
    });

    function previewImage(input) {
        const preview = document.getElementById('img-preview');
        const placeholder = document.getElementById('img-placeholder');
        const replace = document.getElementById('img-replace');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            replace.classList.remove('hidden');
            replace.classList.add('flex');
        }
    }
</script>
@endpush

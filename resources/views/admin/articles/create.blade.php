@extends('admin.layouts.app')

@section('title', 'Create Article — Admin')

@section('content')
{{-- Actions --}}
<div class="flex items-center justify-end mb-6 gap-3">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center h-10 px-4 rounded-lg border border-slate-200 bg-white text-slate-600 text-[13.5px] font-semibold hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit" form="article-form" class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-[#0b57d0] text-white text-[13.5px] font-semibold hover:bg-blue-700 shadow-sm transition">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 4h11l3 3v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm3 0v5h8V4M7 15h10m-10 4h10"/></svg>
            Save Article
        </button>
    </div>
{{-- Validation errors --}}
@if ($errors->any())
    <div class="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-[13.5px]">
        <p class="font-semibold mb-1">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
                       value="{{ old('title') }}"
                       oninput="autoSlug(this.value)"
                       class="w-full h-11 px-3.5 rounded-lg border border-slate-300 text-[14px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">

                {{-- Slug --}}
                <label for="slug" class="block text-[13.5px] font-semibold text-slate-800 mt-5 mb-2">Slug</label>
                <div class="flex items-center h-11 rounded-lg border border-slate-300 bg-white overflow-hidden focus-within:border-[#0b57d0] focus-within:ring-2 focus-within:ring-blue-500/20 transition">
                    <span class="h-full px-3.5 flex items-center text-[13px] text-slate-400 bg-slate-50 border-r border-slate-200 whitespace-nowrap">indotech.com/blog/</span>
                    <input id="slug" name="slug" type="text" placeholder="article-slug" value="{{ old('slug') }}"
                           class="h-full flex-1 min-w-0 px-3.5 text-[14px] text-slate-900 placeholder-slate-400 outline-none bg-transparent">
                </div>
                <p class="text-[12px] text-slate-400 mt-1.5">Auto-generated from title. You can change it.</p>
            </div>

            {{-- Excerpt --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label for="excerpt" class="block text-[13.5px] font-semibold text-slate-800 mb-2">Excerpt / Summary</label>
                <textarea id="excerpt" name="excerpt" rows="3" placeholder="Short summary of the article (shown on listing pages)…"
                          class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('excerpt') }}</textarea>
            </div>

            {{-- Content --}}
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
                    </div>
                    {{-- Editor area --}}
                    <textarea id="content" name="content" rows="14" placeholder="Write your article content here…"
                              class="w-full px-5 py-4 text-[14px] text-slate-800 leading-relaxed placeholder-slate-400 outline-none bg-white resize-y min-h-[280px]">{{ old('content') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT: Sidebar panel ===== --}}
        <div class="space-y-6">

            {{-- Publish Status --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label for="status" class="block text-[13.5px] font-semibold text-slate-800 mb-2">Publish Status <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select id="status" name="status"
                            class="w-full h-11 px-3.5 pr-9 rounded-lg border border-slate-300 bg-white text-[14px] text-slate-900 appearance-none outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft"     {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived"  {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m8 10 4 4 4-4"/></svg>
                </div>
            </div>

            {{-- Category --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label for="category" class="block text-[13.5px] font-semibold text-slate-800 mb-2">Category <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select id="category" name="category"
                            class="w-full h-11 px-3.5 pr-9 rounded-lg border border-slate-300 bg-white text-[14px] text-slate-900 appearance-none outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                        @foreach (['Technology','Education','Career','News','AI','Programming','Web Development','Cybersecurity','Cloud','Database','UI/UX','Press Release'] as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m8 10 4 4 4-4"/></svg>
                </div>
            </div>

            {{-- Author --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-[14px] font-bold text-slate-800">Author Info</h3>
                <div>
                    <label for="author_name" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Author Name</label>
                    <input id="author_name" name="author_name" type="text" value="{{ old('author_name') }}"
                           placeholder="e.g. Budi Santoso"
                           class="w-full h-10 px-3.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label for="author_role" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Author Role</label>
                    <input id="author_role" name="author_role" type="text" value="{{ old('author_role') }}"
                           placeholder="e.g. Senior Software Engineer"
                           class="w-full h-10 px-3.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label for="read_time" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Read Time</label>
                    <input id="read_time" name="read_time" type="text" value="{{ old('read_time') }}"
                           placeholder="e.g. 5 min read"
                           class="w-full h-10 px-3.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label class="block text-[13.5px] font-semibold text-slate-800 mb-2">Featured Image</label>
                <div class="flex items-center space-x-4 mb-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="image_source" value="url" checked class="mr-1">
                        URL
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="image_source" value="upload" class="mr-1">
                        Upload
                    </label>
                </div>
                <div id="image-url-field" class="mb-2">
                    <input id="image" name="image" type="url" value="{{ old('image') }}"
                           placeholder="https://images.unsplash.com/…"
                           class="w-full h-10 px-3.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                    <p class="text-[12px] text-slate-400 mt-1.5">Paste a public image URL for the article thumbnail.</p>
                </div>
                <div id="image-upload-field" class="hidden mb-2">
                    <input id="image_file" name="image_file" type="file" accept="image/*"
                           class="w-full h-10 px-3.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                    <p class="text-[12px] text-slate-400 mt-1.5">Upload an image file for the article thumbnail.</p>
                </div>
                <script>
                    document.querySelectorAll('input[name="image_source"]').forEach(function(el){
                        el.addEventListener('change', function(){
                            if(this.value === 'url'){
                                document.getElementById('image-url-field').classList.remove('hidden');
                                document.getElementById('image-upload-field').classList.add('hidden');
                            } else {
                                document.getElementById('image-url-field').classList.add('hidden');
                                document.getElementById('image-upload-field').classList.remove('hidden');
                            }
                        });
                    });
                </script>
            </div>

            {{-- Meta & SEO --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
                <h3 class="text-[14px] font-bold text-slate-800">Meta & SEO</h3>
                <div>
                    <label for="tags" class="block text-[13px] font-semibold text-slate-700 mb-2">Tags (comma separated)</label>
                    <input id="tags" name="tags" type="text" value="{{ old('tags') }}"
                           placeholder="e.g. AI, Technology, Laravel"
                           class="w-full h-10 px-3.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label for="meta_description" class="block text-[13px] font-semibold text-slate-700 mb-2">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" placeholder="Short meta description for SEO"
                              class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-[13.5px] text-slate-900 placeholder-slate-400 bg-white outline-none transition focus:border-[#0b57d0] focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function autoSlug(value) {

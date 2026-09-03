@extends('admin.layouts.app')

@section('title', '{{ $company["name"] }} — IndoTech')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    {{-- Top Back Link & Breadcrumb --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route('admin.company.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Companies
        </a>
        <nav class="flex items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.company.index') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Companies</a>
            <span>/</span>
            <span class="text-gray-900 dark:text-white font-medium">{{ $company["name"] }}</span>
        </nav>
    </div>

    {{-- Page Header with Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $company->name }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Company details and information</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.company.edit', $company) }}" class="px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-800 dark:hover:bg-indigo-900/50 transition-colors">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('admin.company.destroy', $company) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this company?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800 dark:hover:bg-red-900/50 transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Status & Basic Info Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
                </div>
                <div class="p-6 space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($company->status === 'active')
                                    bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @else
                                    bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @endif
                            ">
                                {{ ucfirst($company->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-gray-900 dark:text-white">{{ $company->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                            <p class="text-gray-900 dark:text-white">{{ $company->phone ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Website</p>
                            <p class="text-gray-900 dark:text-white">{{ $company->website ? '<a href="'.$company->website.'" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:underline">'.$company->website.'</a>' : '—' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                            <p class="text-gray-900 dark:text-white">{{ $company->address ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description Card --}}
            @if($company->description)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Description</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $company->description }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column: Meta Info --}}
        <div class="space-y-6">
            {{-- Metadata Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Metadata</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">ID</p>
                        <p class="text-gray-900 dark:text-white font-mono">{{ $company->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                        <p class="text-gray-900 dark:text-white">{{ $company->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Updated At</p>
                        <p class="text-gray-900 dark:text-white">{{ $company->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

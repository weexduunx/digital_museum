@extends('layouts.app')

@section('title', $artwork->title)
@section('description', Str::limit(strip_tags($artwork->description), 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('gallery') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour à la galerie
        </a>
    </div>

    <livewire:artwork-detail :artwork="$artwork" />
</div>
@endsection
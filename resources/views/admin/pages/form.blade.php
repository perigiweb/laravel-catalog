@extends('layouts.admin')

@section('pageTitle')
<div class="d-flex gap-2 align-items-center mb-3">
  <a href="{{ route('admin.pages.index') }}" class="fs-4">
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>
  </a>
  <h1 class="fs-4 mb-0">{{ $pageTitle }}</h1>
</div>
@endsection

@section('content')
    <div class="alert @if (session()->has('message')) d-block mb-3 alert-{{ session('message.type') }} @else d-none @endif" id="message">{{ session('message.text') }}</div>
    <form action="{{ $page->exists ? route('admin.pages.update', ['page' => $page]):route('admin.pages.store') }}" method="POST" novalidate enctype="multipart/form-data">
        @if ($page->exists)
            <input type="hidden" name="_method" value="patch">
        @endif
        @csrf
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
            <input required type="text" id="title" name="title" placeholder="Title"
                class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}">
            <div class="invalid-feedback">@error('title'){{ $message }} @else Post title is required. @enderror</div>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="6"
              class="form-control tinymce @error('content') is-invalid @enderror"
            >{{ old('description', $page->description) }}</textarea>
            <div class="invalid-feedback">@error('description'){{ $message }} @enderror</div>
        </div>
        <div class="mb-3">
          <label for="picture" class="form-label">Picture</label>
            <input type="file" id="picture" name="picture" placeholder="Picture"
                class="form-control @error('picture') is-invalid @enderror" value="">
            <div class="invalid-feedback">@error('picture'){{ $message }} @enderror</div>
        </div>
        <div class="mb-3">
          <label for="instruction" class="form-label">Instruction</label>
            <textarea name="instruction" id="instruction" rows="6"
              class="form-control tinymce @error('content') is-invalid @enderror"
            >{{ old('instruction', $page->instruction) }}</textarea>
            <div class="invalid-feedback">@error('instruction'){{ $message }} @enderror</div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.0.0/tinymce.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            tinyMCE.init({
                selector: '.tinymce',
                plugins: ['link', 'charmap', 'media', 'advlist', 'lists'],
                toolbar: 'blocks bold italic underline strikethrough alignleft aligncenter alignjustify alignright bullist numlist link charmap',
                menubar: false,
                height: '400px',
                image_uploadtab: false,
                image_class_list: [
                    { title: 'Image Fluid', value: 'img-fluid' },
                    { title: 'Image Thumbnail', value: 'img-thumbnail' }
                ],
                iframe_template_callback: data => {
                    return `<div class="ratio ratio-16x9 mb-3"><iframe title="${data.title||''}" width="${data.width||'100%'}" height="${data.height||'100%'}" src="${data.source}"></iframe></div>`
                },
                video_template_callback: data => {
                    return `<div class="ratio ratio-16x9 mb-3"><video width="100%" height="100%"${data.poster ? ` poster="${data.poster}"` : ''} controls="controls">\n` +
                        `<source src="${data.source}"${data.sourcemime ? ` type="${data.sourcemime}"` : ''} />\n` +
                        (data.altsource ? `<source src="${data.altsource}"${data.altsourcemime ? ` type="${data.altsourcemime}"` : ''} />\n` : '') +
                        '</video></div>'
                },
                license_key: 'gpl'
            })
        })
    </script>
@endpush
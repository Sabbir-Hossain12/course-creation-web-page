@extends('layout.master')

@push('backendCss')
    <link href="{{asset('backend')}}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
          rel="stylesheet" type="text/css">
@endpush

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create Course</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Create Course</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{--    Form Starts--}}
    <form  id="createCourse" action="{{ route('course.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            {{--   General Information   --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Course Basic Information</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Course Title *</label>
                                        <input class="form-control" type="text" name="title"
                                               placeholder="Course Title"
                                               id="title" required>
                                        <div class="mt-1">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category *</label>
                                        <input class="form-control" type="text" name="category"
                                               placeholder="Course Category"
                                               id="category" required>
                                        <div class="mt-1">
                                            @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price *</label>
                                        <input class="form-control" type="number" name="price"
                                               placeholder="Course Category"
                                               id="price" required>
                                        <div class="mt-1">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">

                                    <div class="mb-3">
                                        <label for="brand_id" class="form-label">Description *</label>
                                        <textarea class="form-control" name="description" id="description" required></textarea>
                                        <div class="mt-1">
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="feature_video" class="form-label">Feature Video *</label>
                                        <input type="file" class="form-control" name="feature_video" id="feature_video" required>
                                        <div class="mt-1">
                                            @error('feature_video')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Modules and Contents</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- ================= Modules ================= -->
                                <div id="modulesWrapper"></div>

                                <button type="button" id="addModule" class="btn btn-outline-primary mb-3">
                                    + Add Module
                                </button>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
        <div class="m-3">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>
@endsection

@push('backendJs')
    <script>
        $(document).ready(function () {
            let moduleIndex = 0;

            //Add Module
            $('#addModule').click(function () {
                const moduleHtml = `
        <div class="card mb-3 module-item" data-module-index="${moduleIndex}">
          <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <span>Module ${moduleIndex + 1}</span>
            <button type="button" class="btn btn-sm btn-light remove-module">Remove</button>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Module Title</label>
              <input type="text" name="modules[${moduleIndex}][title]" class="form-control" required>
              <div class="mt-1">
                @error('modules.${moduleIndex}.title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Module Description</label>
              <textarea name="modules[${moduleIndex}][description]" class="form-control" rows="2" required></textarea>
              <div class="mt-1">
                @error('modules.${moduleIndex}.description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Module Duration</label>
              <input type="text" name="modules[${moduleIndex}][duration]" class="form-control">
              <div class="mt-1">
                @error('modules.${moduleIndex}.duration')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
                </div>

                <div class="contents-wrapper"></div>

                <button type="button" class="btn btn-sm btn-outline-secondary add-content">+ Add Content</button>
              </div>
            </div>`;
                $('#modulesWrapper').append(moduleHtml);
                moduleIndex++;
            });

            //Remove Module
            $(document).on('click', '.remove-module', function () {
                $(this).closest('.module-item').remove();
            });

            // Add Content
            $(document).on('click', '.add-content', function () {
                const moduleCard = $(this).closest('.module-item');
                const moduleIdx = moduleCard.data('module-index');
                const contentWrapper = moduleCard.find('.contents-wrapper');
                const contentCount = contentWrapper.children().length;

                const contentHtml = `
        <div class="border rounded p-3 mb-2 bg-light position-relative">
          <button type="button" class="btn-close position-absolute top-0 end-0 remove-content"></button>
          <h6 class="text-secondary">Content ${contentCount + 1}</h6>

          <div class="mb-2">
            <label class="form-label">Title</label>
            <input type="text" name="modules[${moduleIdx}][contents][${contentCount}][title]" class="form-control" required>
          </div>

          <div class="mb-2">
            <label class="form-label">Type</label>
            <select name="modules[${moduleIdx}][contents][${contentCount}][type]" class="form-select" required>
              <option value="">Select Type</option>
              <option value="video" selected>Video</option>
            </select>
          </div>

          <div class="mb-2">
            <label class="form-label">Video URL</label>
            <input type="text" name="modules[${moduleIdx}][contents][${contentCount}][video_url]" class="form-control" required>
          </div>

          <div class="mb-2">
            <label class="form-label">Duration (Optional)</label>
            <input type="text" name="modules[${moduleIdx}][contents][${contentCount}][duration]" class="form-control">
          </div>
        </div>`;
                contentWrapper.append(contentHtml);
            });

            // Remove Content
            $(document).on('click', '.remove-content', function () {
                $(this).closest('.border').remove();
            });
        });
    </script>
@endpush

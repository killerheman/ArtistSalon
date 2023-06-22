@extends('admin.includes.layout', ['breadcrumb_title' => 'Services'])
@section('title', 'Services')
@section('main-content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{isset($udata) ? 'Edit':'Register'}} Services</h4>
            </div><!-- end card header -->
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="live-preview">
                    <form action="{{ isset($udata) ? route('admin.services.update', $udata->id) : route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                        @if (isset($udata))
                        @method('patch')
                        @endif
                        @csrf
                        <div class="row gy-4 mb-3">
                            <div class="col-xxl-3 col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ isset($udata) ? $udata->title : '' }}">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <label for="pic" class="form-label">Image</label>
                                <input type="file" class="form-control" name="pic" />
                            </div>
                            <!--end col-->
                        </div>
                        <div class="row gy-4 mb-3">
                            <div class="col-xxl-3 col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="{{ isset($udata) ? $udata->price : '' }}">
                                </div>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="input-group">
                                    <textarea type="text" class=" ckeditor form-control" id="description" name="description" placeholder="description">{!! $udata->description ??'' !!}</textarea>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <div class="row gy-4 mb-3">
                            <div class="col-xxl-3 col-md-6">
                                <button class="btn btn-primary" type="submit">{{ isset($udata) ? 'Update' : 'Submit' }}</button>
                            </div>
                            @if (isset($udata))
                            <div class="col-sm-6">
                                <img src="{{asset($udata->image) }}" class="bg-light-info" alt="" style="height:100px;width:100px;">
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Manage Services</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <table class="table table-nowrap container">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No.</th>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Price</th>
                            <th scope="col">description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                <img src="{{ asset( $service->image) }}" class="me-75 bg-light-danger" style="height:60px;width:60px;" />
                            </td>
                            <td>{{ $service->title ?? '' }}</td>
                            <td>{{ $service->price ?? '' }}</td>
                            <td>{!! $service->description !!}</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    @php $cryptid=Crypt::encrypt($service->id); @endphp

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="{{ route('admin.services.edit', $cryptid) }}">Edit</a></li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('delete-form-{{ $cryptid }}').submit();">Delete</a>
                                            <!-- <a class="btn btn-danger" href="#">
                                                <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                            </a> -->

                                            <form id="delete-form-{{ $cryptid }}" action="{{ route('admin.services.destroy', $cryptid) }}" method="post" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Grids in modals -->
@endsection


@section('script-area')
@endsection
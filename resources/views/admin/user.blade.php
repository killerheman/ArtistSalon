@extends('admin.includes.layout', ['breadcrumb_title' => 'User'])
@section('title', 'User')
@section('main-content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{isset($udata) ? 'Edit':'Register'}} User</h4>
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
                    <form action="{{ isset($udata) ? route('admin.user.update', $udata->id) : route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                        @if (isset($udata))
                        @method('patch')
                        @endif
                        @csrf
                        <div class="row gy-4 mb-3">
                            <div class="col-xxl-3 col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ isset($udata) ? $udata->first_name : '' }}">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ isset($udata) ? $udata->last_name : '' }}">
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <div class="row gy-4 mb-3">
                            <div class="col-xxl-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ isset($udata) ? $udata->email : '' }}">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{ isset($udata) ? $udata->phone : '' }}">
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <div class="row gy-4 mb-3">
                            <div class="col-xxl-3 col-md-6">
                                <label for="email" class="form-label">Select Role</label>
                                <select name="roleid" class="form-select">
                                    <option value="">--Select Role--</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{isset($udata)?($udata->roles[0]->id == $role->id ?'selected':''):''}}>{{ $role->name ??'' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <label for="pic" class="form-label">Image Thumbnail</label>
                                <input type="file" class="form-control" name="pic" />
                            </div>
                        </div>
                        <div class="row gy-4 mb-3">
                            <div class="col-xxl-3 col-md-6">
                                <button class="btn btn-primary" type="submit">{{ isset($udata) ? 'Update' : 'Submit' }}</button>
                            </div>
                            @if (isset($udata))
                            <div class="col-sm-6">
                                <img src="{{asset($udata->pic) }}" class="bg-light-info" alt="" style="height:100px;width:100px;">
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
                <h4 class="card-title mb-0 flex-grow-1">Manage Users</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <table class="table table-nowrap container">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No.</th>
                            <th scope="col">Image</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                <img src="{{ asset( $user->pic) }}" class="me-75 bg-light-danger" style="height:60px;width:60px;" />
                            </td>
                            <td>{{ $user->first_name ?? '' }}</td>
                            <td>{{ $user->last_name ?? '' }}</td>
                            <td>{{ $user->email ?? '' }}</td>
                            <td>{{ $user->phone ?? '' }}</td>
                            <td>{{ $user->roles[0]->name ?? '' }}</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    @php $cryptid=Crypt::encrypt($user->id); @endphp

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <!-- <li><a class="dropdown-item" href="#">View</a></li> -->
                                        <li><a class="dropdown-item" href="{{ route('admin.user.edit', $cryptid) }}">Edit</a></li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('delete-form-{{ $cryptid }}').submit();">Delete</a>
                                            <!-- <a class="btn btn-danger" href="#">
                                                <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                            </a> -->

                                            <form id="delete-form-{{ $cryptid }}" action="{{ route('admin.user.destroy', $cryptid) }}" method="post" style="display: none;">
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
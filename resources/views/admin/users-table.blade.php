@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Products Data
                    </div>
                    <div class="card-body">
                        <div id="products_table">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="text-info">Tools</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    @if($role->name === "admin")
                                                        <span class="text-success"><b>{{$role->name}}</b></span>
                                                    @else
                                                        <span>{{$role->name}}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="/admin/delete-user/{{$user->id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
@endSection
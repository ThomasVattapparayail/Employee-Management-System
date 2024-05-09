@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content  -->

    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Company Tables</h1>
        @auth
        @if(Auth::user()->first_name=="Admin")
            <a type="button" href="/companies/create" class="btn btn-primary offset-md-10" >
                Add Company
            </a>
        @endif
        @endauth    
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Company Data </h6>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Company Email</th>
                                <th>Company Logo</th>
                                <th>Company Website</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Company Name</th>
                                <th>Company Email</th>
                                <th>Company Logo</th>
                                <th>Company Website</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($companys as $company)
                            <tr>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->email }}</td>
                                <td><img src="{{asset('storage/'.$company->logo)}}" alt="Company Logo" width="100" height="100"></td>
                                <td>{{ $company->website }}</td>
                                @auth
                                 @if(Auth::user()->first_name=="Admin")
                                <td>
                                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                                @else
                                  <td><p>Action rescricted</p>
                                @endif
                                @endauth
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
<!-- Content Row -->

@endsection


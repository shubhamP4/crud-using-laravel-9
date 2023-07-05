@extends('layout')
@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <a href="{{ route('product.index') }}"><button class="btn btn-success btn-sm">View Product Page</button></a>              
            </div>
        </div>
    </div>    
</div>
    
@endsection
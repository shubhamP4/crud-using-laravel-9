@extends('layout')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- Filter Form --}}
                <form action="{{ route('product.index') }}" method="GET" class="form-horizontal row p-3">
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ request('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="form-group row">
                            <label for="price" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="price" name="price" value="{{ request('price') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="form-group row">
                            <label for="quantity" class="col-sm-3 col-form-label">Quantity</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="quantity" name="quantity" value="{{ request('quantity') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="form-group row">
                            <label for="category" class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" id="category" name="category">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" id="status" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 offset-sm-2">
                                <button class="btn btn-primary" type="submit">Apply Filters</button>
                                <a href="{{ route('product.index') }}" class="btn btn-secondary">Clear Filters</a>
                            </div>
                        </div>
                    </div>
                </form>
                
                
                <div class="card-header d-flex justify-content-between align-items-center">
                    Products
                    <a href="{{ route('product.create') }}" class="btn btn-success btn-sm">Add Product</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name
                                    <a class="ml-2" href="{{ route('product.index', ['sort_field' => 'name', 'sort_order' => 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-sort-up-alt" viewBox="0 0 16 16">
                                            <path d="M3.5 13.5a.5.5 0 0 1-1 0V4.707L1.354 5.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 4.707V13.5zm4-9.5a.5.5 0 0 1 0-1h1a.5.5 0 0 1 0 1h-1zm0 3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 0 1h-3zm0 3a.5.5 0 0 1 0-1h5a.5.5 0 0 1 0 1h-5zM7 12.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5z"/>
                                        </svg>
                                    </a>
                                </th>
                                <th>Price
                                    <a href="{{ route('product.index', ['sort_field' => 'price', 'sort_order' => 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-sort-up-alt" viewBox="0 0 16 16">
                                            <path d="M3.5 13.5a.5.5 0 0 1-1 0V4.707L1.354 5.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 4.707V13.5zm4-9.5a.5.5 0 0 1 0-1h1a.5.5 0 0 1 0 1h-1zm0 3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 0 1h-3zm0 3a.5.5 0 0 1 0-1h5a.5.5 0 0 1 0 1h-5zM7 12.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5z"/>
                                        </svg>
                                    </a>

                                </th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" width="40">
                                    @else
                                    <img src="https://www.rattanhospital.in/wp-content/uploads/2020/03/user-dummy-pic.png"
                                    alt="product image" width="40">
                                    @endif
                                    
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    @foreach ($product->categories as $key => $category)
                                    {{ $category->name }}
                                    @if ($key < count($product->categories) - 1)
                                        ,
                                    @endif
                                @endforeach
                                </td>  
                                <td> {{ $product->status }}</td>
                                <td>
                                    <form action="{{ route('product.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                    <a href="{{ route('product.edit', ['product' => $product->id]) }}">
                                        <button class="btn btn-primary btn-sm" type="button">Edit</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

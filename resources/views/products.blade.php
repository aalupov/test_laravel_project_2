@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Orders</div>
                    @include('includes.error')
                    @include('includes.success')
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Vendor</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
   @foreach($products as $product)
    <tr>
      <th scope="row">{{ $product->id }}</th>
       <td>{{ $product->name }}</td>
       <td>{{ $product->vendor_name }}</td>
      <td>
            <input type='number' id='{{ $product->id }}' value="{{ $product->price }}">
            <input type='button' class='update' id='{{ $product->id }}' value='Update'>
      </td>
   @endforeach
  </tbody>
</table>
  {{ $products->links() }}  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
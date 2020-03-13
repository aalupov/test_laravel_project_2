@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Orders</div>
                    @include('includes.error')
                    @include('includes.success')
                    @include('includes.links')
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Partner</th>
      <th scope="col">Price</th>
      <th scope="col">Composition</th>    
      <th scope="col">Status</th>   
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
   @foreach($orders as $order)
    <tr>
      <th scope="row">{{ $order->id }}</th>
       <td>{{ $order->name }}</td>
      <td>{{ $order->price }}</td>
      <td>
        @foreach($order->products as $products)
          <li>{{ $products->name }}</li>
        @endforeach 
      </td>
      <td>
       @if($order->status == 0)
        new
       @elseif($order->status == 10)
        approved
       @else
        completed
       @endif 
      </td>   
	  <td data-th="order_edit">
           <a href="{{ route( 'orders.edit', $order->id ) }}" target="_blanc">
			  <button type="submit" class="btn btn-primary">Edit</button>
		   </a>
	  </td>  									    
    </tr>
   @endforeach
  </tbody>
</table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
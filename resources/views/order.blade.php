@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Order</div>
                    @include('includes.error')
                    @include('includes.success')<br>
                   <form method="post" action="{{ route('orders.update', $id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}                                          
                        
                        <div class="form-group row">
                            <label for="client_email" class="col-md-4 col-form-label text-md-right">{{ __('Client E-Mail *') }}</label>

                            <div class="col-md-6">
                               @if($errors->any())
                                 <input id="client_email" type="email" class="form-control @error('client_email') is-invalid @enderror" name="client_email" value="{{ old('client_email') }}" required autocomplete="client_email">
                               @else
                                 <input id="client_email" type="email" class="form-control @error('client_email') is-invalid @enderror" name="client_email" value="{{ $order->client_email }}" required autocomplete="client_email">
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="partner_id" class="col-md-4 col-form-label text-md-right">{{ __('Partner *') }}</label>

                            <div class="col-md-6">
                                 <select name="partner_id" class="form-control @error('partner_id') is-invalid @enderror">
                                   @foreach($partners as $partner)
                                     @if($partner->id == old('partner_id') || $partner->id == $order->partner_id)
                                       <option value="{{ $partner->id }}" selected>{{ $partner->name }}</option>
                                     @else 
                                       <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                     @endif  
                                   @endforeach  
                                 </select>                                
                            </div>
                        </div> 
 
                        <div class="form-group row">
                            <label for="store_state" class="col-md-4 col-form-label text-md-right">{{ __('Products') }}</label>

                            <div class="col-md-6">
                              @foreach($order->products as $product)
                                <li>{{ $product->name }} - Quantity: {{ $product->quantity }}</li>
                              @endforeach 
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status *') }}</label>

                            <div class="col-md-6">
                                <select name="status" class="form-control @error('status') is-invalid @enderror">                                
                                  @if($order->status == 0 || old('status') == 0)
                                    <option value="0" selected>New</option>
                                  @else 
                                    <option value="0">New</option>
                                  @endif
                                  @if($order->status == 10 || old('status') == 10)
                                    <option value="10" selected>Approved</option>
                                  @else 
                                    <option value="10">Approved</option>
                                  @endif   
                                  @if($order->status == 20 || old('status') == 20)
                                    <option value="20" selected>Completed</option>
                                  @else 
                                    <option value="20">Completed</option>
                                  @endif                                                                     
                                </select>                                  
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_picture" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                {{ $order->price }}
                            </div>
                        </div>                        
                                                                                                                                                
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Save') }}
                                </button>                                
                            </div>
                         </div> 
               </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
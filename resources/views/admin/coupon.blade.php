@extends('admin.layouts.app')
@section('content')
    <form action="/admin/create-coupon" method="post" class="form mt-5 border border-dark p-2" id="create">
        @csrf
        <h4>Create Coupon</h4>
        <input type="text" name="name" placeholder="name" class="form-control mt-3">
        <input type="text" name="currency" placeholder="currency" class="form-control mt-3">
        <input type="text" name="percent_off" placeholder="percent_off" class="form-control mt-3">
        <input type="text" name="duration" placeholder="duration" class="form-control mt-3">
        <input type="text" name="max_redemptions" placeholder="max_redemptions" class="form-control mt-3">
        <input type="text" name="redeem_by" placeholder="redeem_by" class="form-control mt-3">
        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>
    <form action="/admin/apply-coupon" method="post" class="form mt-5 border border-dark p-2" id="applie">
        @csrf
        <h4>Applie Coupon</h4>
        <input type="text" name="coupon_id" placeholder="Coupon Id" class="form-control mt-3">
        <hr>
        <input type="text" name="customer_id" placeholder="Customer Id" class="form-control mt-3">
            /OR
        <input type="text" name="product_id" placeholder="to which product you wish apply this coupon <product_stripe_id>" class="form-control mt-3">
        <button type="submit" class="btn btn-success mt-3">Applie</button>
    </form>
@endsection

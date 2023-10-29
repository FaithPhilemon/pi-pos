@extends('accounting.layout')
@section('title', 'Edit Bill')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-user-plus bg-blue"></i>
                    <div class="d-inline">
                        <h5>Income</h5>
                        <span>Edit Bill</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/accounting"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Income</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url('expense/bill')}}">Bill</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 pr-0">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="form-group">
                        <label>Bill No</label>
                        <input type="text" class="form-control" placeholder="Porposal No" value="#BL000045" readonly>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-10 pr-0">
                                <label>Vendor</label>

                                <select class="form-control">
                                    <option selected="selected" value="">Select Vendor</option>
                                    <option value="1" selected>Alex Corporation</option>
                                    <option value="2">John Inc</option>
                                </select>

                            </div>
                            <div class="col-sm-2 pl-1 pt-1">
                                <button type="button" class="mt-4 btn btn-sm btn-primary" data-toggle="modal" data-target="#VendorAdd">+</button>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <label>Issue Date</label>
                        <input type="text" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" placeholder="Select Date" value="17-11-2022">
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="text" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" placeholder="Select Date">
                    </div>
                    <div class="form-group">
                        <label>Category</label>

                        <select class="form-control">
                            <option selected="selected" value="">Select Category</option>
                            <option value="1">Category 1</option>
                            <option value="2" selected>Category 2</option>
                            <option value="3">Category 3</option>
                            <option value="4">Category 4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea class="form-control h-123" name="note" placeholder="Enter Note">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pulvinar tempor ex, in blandit risus bibendum vel.</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-0">
                <div class="card-header">
                    <h3>Product & Services</h3>
                    <div class="card-header-right">
                    <button type="button" class="btn btn-success add-product-item"><i class="ik ik-plus"></i> Add Item</button>
                        </div>
                </div>
                <div class="card-body">
                    <div class="salestable">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="wp-40">Item</th>
                                    <th class="wp-10">Quantity</th>
                                    <th class="wp-20">Unit Price</th>
                                    <th class="wp-15">Discount</th>
                                    <th class="wp-15 text-right">Sub Total</th>
                                    <th class="wp-15 text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $billItems = config('mockdata.invoice_items');
                                $grandTotal = 0;
                                $grandDiscount = 0;
                            @endphp

                            @foreach($billItems as $key => $product)
                            
                            @php

                                $subtotal = $product['qty'] * ($product['unit_price'] - $product['discount']);
                                $grandTotal += $subtotal;
                            @endphp
                                <tr class="base-tr">
                                    <td class="pl-0"><input type="text" name="item" value="{{$product['name']}}" class="form-control hm-30"></td>
                                    <td><input type="text" name="quantity" class="form-control w-60 text-center hm-30" value="{{$product['qty']}}"> </td>
                                    <td><input type="text" name="unit_price" class="form-control  hm-30" value="{{$product['unit_price']}}"></td>
                                    <td><input type="text" name="discount" class="form-control w-60 text-center hm-30" value="{{$product['discount']}}"></td>
                                    <td class="text-right">{{number_format($subtotal, 2, '.', '')}}</td>
                                    <td><i class="ik ik-trash-2 f-16 text-red remove-second-parent cursor-pointer"></i></td>
                                </tr>
                            @endforeach

                            @php
                            $taxAmount = $grandTotal * 0.1;
                            $grandTotalWithTax = $grandTotal + $taxAmount;

                            @endphp
                                <tr id="product-line-separator">
                                    <td colspan="6"></td>
                                </tr>
                                <tr>
                                    <th class="border-0" colspan="3"></th>
                                    <th class="border-0">Total</th>
                                    <th class="text-right border-0">{{number_format($grandTotal, 2, '.', '')}}</th>
                                    <td class="border-0"></td>
                                </tr>
                                <tr>
                                    <td class="border-0" colspan="3"></td>
                                    <td>Tax (<span id="tax-per">10.00</span>%)</td>
                                    <td class="text-right">{{number_format($taxAmount, 2, '.', '')}}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th class="border-0" colspan="3"></th>
                                    <th>Grand Total</th>
                                    <th class="text-right">{{number_format($grandTotalWithTax, 2, '.', '')}}</th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group text-right">
                            <div type="submit" class="btn btn-primary">Update</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('page_title')
    Add Item
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Product</a></li>
                            <li class="breadcrumb-item active">All Products</li>
                        </ol>
                    </div>
                    <div class="col-md-2 offset-4" >
                        <button type="button" class="btn btn-primary btn-block add_item mr-2 btn-sm py-2">
                            <i class="fe fe-plus-circle"> </i> Add New Item
                        </button>
                    </div>
                </div>
            </div>

       

            <div class="row mt-5">
                @foreach ($products as $product)
                    <div class="col-xl-3 col-lg-3x col-sm-6">
                        <div class="card shadow text-center">
                            <div class="card-body">
                                <div class="user-content">
                                    <div class="user-info">
                                        <div class="user-img">
                                            <img src="{{ Avatar::create($product->name)->toBase64() }}"
                                                class="rounded-circle " style="width: 50px" />
                                        </div>
                                        <div class="user-details mt-2">
                                            <h4 class="user-name fw-bold fs-6 mb-0">{{ $product->name }}</h4>
                                            <p>{{ money($product->price) }} |
                                                {{ number_format($product->stock_bag) }} bags |
                                                {{ number_format($product->stock_weight) }} kg </p>
                                        </div>
                                    </div>
                                </div>
                                <div class=" d-flex justify-content-center text-white  mb-2 mt-0">
                                    <span
                                        class="badge bg-danger light">{{ date('j M, Y', strtotime($product->created_at)) }}</span>
                                </div>
                                <div class="d-flex justify-content-center ">
                                    <a href="/control/general-stock-legder/{{ $product->id }}"
                                        class="btn-secondary shadow mt-2 btn-sm w-50"><i class="fa fa-book mr-2"></i>Stock
                                        Ledger</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>



            <div class="modal fade" id="add_product" tabindex="-1" role="dialog" aria-labelledby="invoicePaymentAddTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-0" id="exampleModalLongTitle">Create Product </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" class="row" action="/control/add_product">
                                @csrf
                                <div class="col-lg-12 mb-2 ">
                                    <div class="alert alert-warning w-100">
                                        Fill the form below to add new item
                                    </div>
                                </div>
                                <div class="col-lg-8 mb-2 ">
                                    <label class="form-label">Item Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control py-1" placeholder="Item Name"
                                        required autocomplete="zpo">
                                </div>
                                <div class="col-lg-4 ">
                                    <label class="form-label">Price<span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control py-1"
                                        placeholder="Enter Item Price" required>
                                </div>

                                <div class="col-lg-12 mb-3 mb-3 mt-2">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control py-1" rows="2"></textarea>


                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn py-2 btn-primary">Save Item</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endsection


        @push('scripts')
            <script>
                $(function() {

                    $('.add_item').on('click', function() {
                        $('#add_product').modal('show');
                    })

                    $('.add_category').on('click', function() {
                        $('#add_category').modal('show');
                    })

                    $('.open-uploadsheet').on('click', function() {
                        $('#uploadsheet').modal('show');
                    })



                    $('.editItem').on('click', function() {
                        data = $(this).data('data');
                        console.log(data);
                        modal = $('#editModal');
                        form = modal.find('form');
                        form.find('input[name="id"]').val(`${data.id}`)
                        form.find('input[name="name"]').val(`${data.name}`)
                        form.find('input[name="brand"]').val(`${data.brand}`)
                        form.find('input[name="price"]').val(`${data.price}`)
                        form.find('select[name="category_id"]').val(`${data.category_id}`);
                        form.find('textarea[name="description"]').html(`${data.description}`)
                        modal.modal('show');
                    });

                })
            </script>
        @endpush

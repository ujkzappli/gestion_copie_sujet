@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
    <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
        <div class="col">
            <div class="alert-success alert mb-0">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light"><i class="fa fa-dollar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Revenue</div>
                        <span class="small">$18,925</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="alert-danger alert mb-0">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="fa fa-credit-card fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Expense</div>
                        <span class="small">$11,024</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="alert-warning alert mb-0">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-smile-o fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">Happy Clients</div>
                        <span class="small">8,925</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="alert-info alert mb-0">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-shopping-bag" aria-hidden="true"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">New StoreOpen</div>
                        <span class="small">8,925</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Row end  -->

    {{-- Ajoutez ici le reste du contenu du dashboard --}}
    {{-- Pour la démo, je montre juste une section --}}

    <div class="row g-3 mb-3"> 
        <div class="col-md-12">
            <div class="card"> 
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Recent Transactions</h6>
                </div>
                <div class="card-body"> 
                    <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">  
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Item</th>
                                <th>Customer Name</th>
                                <th>Payment Info</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>#Order-78414</strong></td>
                                <td><img src="{{ asset('assets/images/product/product-1.jpg') }}" class="avatar lg rounded me-2" alt="profile-image"><span> Oculus VR </span></td>
                                <td>Molly</td>
                                <td>Credit Card</td>
                                <td>$420</td>
                                <td><span class="badge bg-warning">Progress</span></td>
                            </tr>
                            <tr>
                                <td><strong>#Order-58414</strong></td>
                                <td><img src="{{ asset('assets/images/product/product-2.jpg') }}" class="avatar lg rounded me-2" alt="profile-image"><span>Wall Clock</span></td>
                                <td>Brian</td>
                                <td>Debit Card</td>
                                <td>$220</td>
                                <td><span class="badge bg-success">Complited</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- Row end  -->
@endsection

@push('scripts')
    <script src="{{ asset('js/page/index.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1Jr7axGGkwvHRnNfoOzoVRFV3yOPHJEU&callback=myMap"></script>
    <script>
        $('#myDataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ]
        });
    </script>
@endpush
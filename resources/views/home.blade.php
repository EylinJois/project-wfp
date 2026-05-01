@extends('layouts.adminlte4')

@section('title', 'Home')
@section('menu-home', 'active')

@section('content')

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                 class="d-block w-100" 
                 style="height: 400px; object-fit: cover; object-position: center;" 
                 alt="Third slide">
        </div>
        <div class="carousel-item active">
            <img src="https://cdn-assets-eu.frontify.com/s3/frontify-enterprise-files-eu/eyJwYXRoIjoiaWhoLWhlYWx0aGNhcmUtYmVyaGFkXC9maWxlXC81Q05IMkVRVDZ2dHYzWHVvaFZCcS5wbmcifQ:ihh-healthcare-berhad:XgOhKWzWefi1kZz_ewrQeA9NEnA0jxDqB_RTPx2LP7k?format=webp" 
                 class="d-block w-100" 
                 style="height: 400px; object-fit: cover; object-position: center;" 
                 alt="First slide">
        </div>
        <div class="carousel-item">
            <img src="https://hmcarchitects.com/wp-content/uploads/1426001000_N7_hmcfull-1.jpg" 
                 class="d-block w-100" 
                 style="height: 400px; object-fit: cover; object-position: center;" 
                 alt="Second slide">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="card-body py-5">
    <div class="d-flex flex-column align-items-center text-center">
        
        <h1 class="display-4 fw-bold mb-3">VitaGuard</h1>
        
        <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
            Healthcare platform for online consultations and doctor appointments
        </p>
        
        <a href="#" class="btn btn-primary btn-lg px-5 py-3 shadow">
            Our Services
        </a>
        
    </div>
</div>
@endsection
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Lexus Details</title>
<link rel="shortcut icon" href="favicon.png">
<!-- Common css -->
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/viewport.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
<!-- font -->
<link rel="stylesheet" href="{{asset('assets/font/stylesheet.css')}}">
<!-- owl carousel -->
<link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-icons.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/jquery.fancybox.min.css')}}">
<!-- animation -->
<link href="assets/css/aos.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<!-----header start------>

<header class="fixed-top" id="banner">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="navbar navbar-expand-lg p-0 main-navigation"> 
          <!--  Show this only on mobile to medium screens  --> 
          <a class="navbar-brand logo" href="#"> <img src="{{asset('assets/images/lexus-logo.svg')}}" class="img-fluid" alt="logo" width="" /> </a> </nav>
      </div>
    </div>
  </div>
</header>

<!-----header end------> 

<!-- Button trigger modal --> 

<!-- Modal -->
<div class="modal fade enquiryModal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="{{ route('enquiry') }}" method="POST">
        @csrf
          <div class="enquirySec">
            <div class="enquiryImg"> <img src="assets/images/enquiry-image.webp"/> </div>
            <div class="enquiryForm">
              <h1 class="modal-title" id="staticBackdropLabel">Make an Enquiry</h1>
              <p>Feel free to contact with us, we would love to assist you</p>
              <div class="enquiryFormBlock">
                <div class="chooseCheck">
                  <div class="form-check form-check-inline">
                    {!! Form::radio('courtesy_title', 'option1', old('courtesy_title') == 'option1', ['class' => 'form-check-input', 'id' => 'inlineRadio1']) !!}
                    {!! Form::label('inlineRadio1', 'Mr.', ['class' => 'form-check-label']) !!}
                  </div>
                  <div class="form-check form-check-inline">
                    {!! Form::radio('courtesy_title', 'option2', old('courtesy_title') == 'option2', ['class' => 'form-check-input', 'id' => 'inlineRadio2']) !!}
                    {!! Form::label('inlineRadio2', 'Mrs.', ['class' => 'form-check-label']) !!}
                  </div>
                  <div class="form-check form-check-inline">
                    {!! Form::radio('courtesy_title', 'option3', old('courtesy_title') == 'option3', ['class' => 'form-check-input', 'id' => 'inlineRadio3']) !!}
                    {!! Form::label('inlineRadio3', 'Ms.', ['class' => 'form-check-label']) !!}
                  </div>
                </div>
                <div class="row formBlock">
                  <div class="col-lg-12">
                    <label for="exampleFormControlInput1" class="form-label">Name*</label>
                    {!! Form::text('name', old('name'), array('class'=>'form-control', 'id'=>'name','placeholder'=>'')) !!} 
                    <span  class="text-danger error" style="color:#e03b3b" id="name_error">{{ $errors->first('name') }}</span> 
                    </div>
                </div>
                <div class="row formBlock formBlockSelect">
                  <div class="col-lg-12">
                    <label for="exampleFormControlInput1" class="form-label">Mobile Number*</label>
                  </div>
                  <div class="col-lg-4">
                    <select class="form-select" aria-label="Default select example">
                      <option selected>+91</option>
                    </select>
                  </div>
                  <div class="col-lg-8">
                  {!! Form::text('phone', old('phone'), array('class'=>'form-control', 'id'=>'phone','placeholder'=>'')) !!}
                  <span  class="text-danger error" style="color:#e03b3b" id="phone_error">{{ $errors->first('phone') }}</span>  
                  </div>
                </div>
                <div class="row formBlock formBlockCityModel">
                  <div class="col-lg-6">
                    <label for="exampleFormControlInput1" class="form-label">City</label>
                    {!! Form::text('city', old('city'), array('class'=>'form-control', 'id'=>'city','placeholder'=>'')) !!}
                    <span  class="text-danger error" style="color:#e03b3b" id="city_error">{{ $errors->first('city') }}</span>  
                  </div>
                  <div class="col-lg-6">
                    <label for="exampleFormControlInput1" class="form-label">Vehicle Model</label>
                    {!! Form::text('vehicle_model', old('vehicle_model'), array('class'=>'form-control', 'id'=>'vehicle_model','placeholder'=>'')) !!}
                    <span  class="text-danger error" style="color:#e03b3b" id="vehicle_model_error">{{ $errors->first('vehicle_model') }}</span>  
                  </div>
                </div>
                <!-- <div class="row formBlock">
                  <div class="col-lg-12">
                    <label for="exampleFormControlInput1" class="form-label">Job Title</label>
                    {!! Form::text('job_title', old('job_title'), array('class'=>'form-control', 'id'=>'job_title','placeholder'=>'')) !!} 
                  </div>
                </div> -->
                <!-- <div class="row formBlock">
                  <div class="col-lg-12">
                    <label for="exampleFormControlInput1" class="form-label">Company</label>
                    {!! Form::text('city', old('city'), array('class'=>'form-control', 'id'=>'city','placeholder'=>'')) !!} 
                  </div>
                </div> -->
                <div class="row formBlock">
                  <div class="col-lg-12">
                    <label for="exampleFormControlTextarea1" class="form-label">Message/Comments</label>
                    {!! Form::textarea('comments', old('comments'), array('class'=>'form-control', 'id'=>'comments', 'rows'=>'3', 'placeholder'=>'')) !!} 
                  </div>
                </div>
                <div class="row formBlock">
                  <div class="col-lg-12 text-end">
                    <button type="submit" class="primaryBtn">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-----slider start------>
<section class="slider_section_inner">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 ">
        <div class="detailTitle">
          <h2>THE  LEXUS <span class="f_bold">ES</span> SERIES</h2>
          <a class="line_btn" href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Enquiry <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
          <path d="M12.5 6L13.055 5.4955L13.5136 6L13.055 6.5045L12.5 6ZM1.13636 6.75C0.72215 6.75 0.386364 6.41421 0.386364 6C0.386364 5.58579 0.72215 5.25 1.13636 5.25L1.13636 6.75ZM8.5095 0.495495L13.055 5.4955L11.945 6.5045L7.39959 1.5045L8.5095 0.495495ZM13.055 6.5045L8.5095 11.5045L7.39959 10.4955L11.945 5.4955L13.055 6.5045ZM12.5 6.75L1.13636 6.75L1.13636 5.25L12.5 5.25L12.5 6.75Z" fill="white"/>
          </svg></a> </div>
      </div>
      <div class="col-lg-12 ">
        <div id="carouselInner" class="carousel slide" data-bs-ride="carousel">
         
          <div class="carousel-inner">
             @if(count($bannerImagesArray)>0)
          @foreach ($bannerImagesArray as $index => $banner)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"> <img src="{{asset($banner)}}" class="d-block w-100" alt="..."> </div>
              @endforeach
          @endif
          </div>
        
          
          <div class="carousel-indicators">
            @if(count($bannerImagesArray)>0)
          @foreach ($bannerImagesArray as $indx => $banner)
            <button type="button" data-bs-target="#carouselInner" data-bs-slide-to="{{$indx}}" class="{{ $indx === 0 ? 'active' : '' }}"  {{ $indx === 0 ? 'aria-current="true"' : '' }}    aria-label="Slide {{$indx}}"> </button>
               @endforeach
          @endif
          </div>
     
        </div>
      </div>
      <div class="col-lg-12 detailContent"  data-aos="fade-up" data-aos-duration="2500">
        <p> The ES 300h exquisite pairs a 2.5-liter direct injection engine with a powerful, self-charging electric motor to deliver 214 horsepower with maximum fuel efficiency. </p>
        <a class="line_btn" href="">Download Brochure <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
        <path d="M8 10L7.29289 10.7071L8 11.4142L8.70711 10.7071L8 10ZM9 1C9 0.447715 8.55229 2.42698e-07 8 2.18557e-07C7.44772 1.94416e-07 7 0.447715 7 1L9 1ZM2.29289 5.70711L7.29289 10.7071L8.70711 9.29289L3.70711 4.29289L2.29289 5.70711ZM8.70711 10.7071L13.7071 5.70711L12.2929 4.29289L7.29289 9.29289L8.70711 10.7071ZM9 10L9 1L7 1L7 10L9 10Z" fill="white"/>
        <path d="M1 12L1 13C1 14.1046 1.89543 15 3 15L13 15C14.1046 15 15 14.1046 15 13V12" stroke="white" stroke-width="2"/>
        </svg> </a> </div>
    </div>
  </div>
</section>

<!-----slider end------>

<div class="whole-section">
  <section class="explorevehicle_section">
    <div class="container" data-aos="fade-up" data-aos-duration="2500">
      <div class="row">
        <div class="col-lg-12 ">
          <h2> EXPLORE YOUR ES</h2>
        </div>
      </div>
    </div>
    <div class="flex_sec pro_flex_sec" data-aos="fade-up" data-aos-duration="2500">
      <div class="exploreTitle exploreTitle-lg">
        <h3>ES 300h Exquisite <span>Hybrid Electric</span></h3>
        <div class="priceRight">From  INR 64,00,000</div>
      </div>
      <div class="exploreDataSec">
        <div class="flex_image_div"> <img class="w-100" src="{{asset('assets/images/details/car1.png')}}"> </div>
        <div class="exploreTitle exploreTitle-sm"> <span>Hybrid Electric</span>
          <div class="priceRight">From  INR 64,00,000</div>
        </div>
        <div class="flex_content_div">
          <div class="exploreFeatureSec d-flex flex-fill">
            <div class="exploreFeature"> <span>160 kW</span> Power </div>
            <div class="exploreFeature"> <span>8.9 sec</span> Acceleration (0-100 km/h) </div>
            <div class="exploreFeature"> <span>180 km/h</span> Max Speed </div>
          </div>
          <div class="exploreCTA"> <a class="line_btn line_btn_dark" href="">Enquiry <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
            <path d="M12.5 6L13.055 5.4955L13.5136 6L13.055 6.5045L12.5 6ZM1.13636 6.75C0.72215 6.75 0.386364 6.41421 0.386364 6C0.386364 5.58579 0.72215 5.25 1.13636 5.25L1.13636 6.75ZM8.5095 0.495495L13.055 5.4955L11.945 6.5045L7.39959 1.5045L8.5095 0.495495ZM13.055 6.5045L8.5095 11.5045L7.39959 10.4955L11.945 5.4955L13.055 6.5045ZM12.5 6.75L1.13636 6.75L1.13636 5.25L12.5 5.25L12.5 6.75Z" fill="white"/>
            </svg></a> </div>
        </div>
      </div>
    </div>
    <div class="flex_sec pro_flex_sec" data-aos="fade-up" data-aos-duration="2500">
      <div class="exploreTitle exploreTitle-lg">
        <h3>ES 300h Luxury <span>Hybrid Electric</span></h3>
        <div class="priceRight">From  INR 69,70,000</div>
      </div>
      <div class="exploreDataSec">
        <div class="flex_image_div"> <img class="w-100" src="{{asset('assets/images/details/car1.png')}}"> </div>
        <div class="exploreTitle exploreTitle-sm"> <span>Hybrid Electric</span>
          <div class="priceRight">From  INR 69,70,000</div>
        </div>
        <div class="flex_content_div">
          <div class="exploreFeatureSec d-flex flex-fill">
            <div class="exploreFeature"> <span>160 kW</span> Power </div>
            <div class="exploreFeature"> <span>8.9 sec</span> Acceleration (0-100 km/h) </div>
            <div class="exploreFeature"> <span>180 km/h</span> Max Speed </div>
          </div>
          <div class="exploreCTA"> <a class="line_btn line_btn_dark" href="">Enquiry <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
            <path d="M12.5 6L13.055 5.4955L13.5136 6L13.055 6.5045L12.5 6ZM1.13636 6.75C0.72215 6.75 0.386364 6.41421 0.386364 6C0.386364 5.58579 0.72215 5.25 1.13636 5.25L1.13636 6.75ZM8.5095 0.495495L13.055 5.4955L11.945 6.5045L7.39959 1.5045L8.5095 0.495495ZM13.055 6.5045L8.5095 11.5045L7.39959 10.4955L11.945 5.4955L13.055 6.5045ZM12.5 6.75L1.13636 6.75L1.13636 5.25L12.5 5.25L12.5 6.75Z" fill="white"/>
            </svg></a> </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-----gallery with scroll start------>
  
  <section class="gallery_section sec_padding" data-aos="fade-up" data-aos-duration="2500">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="text-white">Gallery</h2>
        </div>
        <div class="col-12">
          <ul class="nav nav-pills mb-3 tabHead" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-exterior-tab" data-bs-toggle="pill" data-bs-target="#pills-exterior" type="button" role="tab" aria-controls="pills-exterior" aria-selected="false">Exterior</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-interior-tab" data-bs-toggle="pill" data-bs-target="#pills-interior" type="button" role="tab" aria-controls="pills-interior" aria-selected="false">Interior</button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
              <div class="custom-nav ms-auto">
                <button class="owl-prev"> <img src="{{asset('assets/images/details/arrowLeft.svg')}}"/> </button>
                <button class="owl-next"> <img src="{{asset('assets/images/details/arrowRight.svg')}}"/> </button>
              </div>
              <div class="owl-carousel gallery_carousel owl-theme">
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="{{asset('assets/images/details/gallery/gallery1.webp')}}" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery1-sm.webp"/> </a> </div>
                  </div>
                </div>
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="{{asset('assets/images/details/gallery/gallery2.webp')}}" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery2-sm.webp"/> </a> </div>
                  </div>
                </div>
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="assets/images/details/gallery/gallery3.webp" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery3-sm.webp"/> </a> </div>
                  </div>
                </div>
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="assets/images/details/gallery/gallery4.webp" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery4-sm.webp"/> </a> </div>
                  </div>
                </div>
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="assets/images/details/gallery/gallery5.webp" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery5-sm.webp"/> </a> </div>
                  </div>
                </div>
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="assets/images/details/gallery/gallery6.webp" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery6-sm.webp"/> </a> </div>
                  </div>
                </div>
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="assets/images/details/gallery/gallery7.webp" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery7-sm.webp"/> </a> </div>
                  </div>
                </div>
                <div class="item">
                  <div class="gallery_block">
                    <div class="gallery_blockinner"> <a href="assets/images/details/gallery/gallery8.webp" data-fancybox="images" data-caption="My caption"> <img src="assets/images/details/gallery/gallery8-sm.webp"/> </a> </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-exterior" role="tabpanel" aria-labelledby="pills-exterior-tab" tabindex="0">02</div>
            <div class="tab-pane fade" id="pills-interior" role="tabpanel" aria-labelledby="pills-interior-tab" tabindex="0">03</div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-----gallery with scroll ends------> 
  
  <!-----features accordion start------>
  
  <section class="features_section " data-aos="fade-up" data-aos-duration="2500">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2>ES Features</h2>
        </div>
        <div class="col-12">
          <div class="accordion featureAccordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Conquer the Road </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="{{asset('assets/images/details/feature-image1.webp')}}" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p>A proprietary Lexus method is used to produce highly rigid rear suspension-member braces. This allows for superior steering stability and a linear driving sensation even when performing high-speed lane changes.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Elegance Meets Style </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image2.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p>The ES has a sharp, elegant appearance with a newly designed front grille, slender headlamp units, and stylish wheels. Adding a touch of class are our specially developed colors – Sonic Iridium and Sonic Chrome. These body paints offer the ES a metallic, high-gloss finish.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Hands-Free Power Back Door </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image3.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p> Even if both hands are full, when carrying the Electronic Key you
                        can open and close the trunk lid automatically by moving your foot under the rear bumper and out again. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> A Luxurious Cabin </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image4.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p> Our <em>takumi</em> craftsmen have made the interior of the ES a tranquil space. Elevating the design is a luxurious walnut material finish and intricate hairline ornamentation that is etched one at a time using a laser. These artistic elements work together to create a serene ambience. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> Total Control </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image5.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p> We gave the brake pedal an expanded surface area to increase the contact area for your foot. The lateral rigidity of the pedal has also been enhanced. Together, these upgrades improve your sense of stability when braking. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"> Optimal Rear Cabin Experience </button>
              </h2>
              <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image6.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p>The ventilated seats, Lexus climate concierge and reclining rear seats make your ride more comfortable and luxurious. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven"> Innovative Infotainment System </button>
              </h2>
              <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image7.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p> Surround your senses with the all new 31.24 cm (12.3 inch) touch-screen display made of glass for improved visibility and positioned at a perfect angle and optimum distance for easy access, wireless charging tray, 17-speaker Mark Levinson Premium Surround Sound System. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight"> Smartphone Connectivity (Apple Carplay & Android Auto) </button>
              </h2>
              <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image8.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p> While on the road, seamlessly access dedicated smartphone features on the large, high-res display. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenine" aria-expanded="false" aria-controls="collapsenine"> Nanoe-X <sup>TM</sup> </button>
              </h2>
              <div id="collapsenine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="assets/images/details/feature-image9.webp" alt="..."> </div>
                    <div class="flex-grow-1 ms-3">
                      <p> The climate control system integrates advanced nanoe-X
                        technology, which releases microscopic, negatively-charged
                        “nanoe-X” particles, helping to purify the cabin air
                        and effectively deodorize the seats and upholstery. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-----features accordion ends------> 
  
  <!-----contact us start------>
  
  <section class="homecontact_section"  >
    <div class="container-fluid">
      <div class="row d-flex">
        <div class="col-lg-6"> <img class="w-100 lexusimgLeft" src="{{asset('assets/images/lexus-left-image.webp')}}"/> </div>
        <div class="col-lg-6">
          <div class="lexusContact" data-aos="fade-up" data-aos-duration="2500">
            <div class="addressTitle">We are in Kochi, Visit Us</div>
            <div class="address"> <span>Lexus Kochi</span> Nippon Motor Corporation Pvt.Ltd<br>
              Nippon Towers, NH544, <br>
              HMT Junction, South Kalamassery, <br>
              Kochi - 683104, Kerala, India </div>
            <div class="contact"> <a href="">0484-7170000</a></div>
            <div class="email"> <a href="">contact@lexuskochi.co.in</a></div>
            <div class="socialMediaSection"> <span>Join us on</span>
              <div class="socialMediaBlock">
                <div class="socialMedia"> <a href=""> <img src="assets/images/Facebook.svg" /> <span>Facebook</span> </a> </div>
                <div class="socialMedia"> <a href=""> <img src="assets/images/Instagram.svg" /> <span>Instagram</span> </a> </div>
                <div class="socialMedia"> <a href=""> <img src="assets/images/Youtube.svg" /> <span>Youtube</span> </a> </div>
              </div>
            </div>
          </div>
          <div class="lexusMap" data-aos="fade-up" data-aos-duration="2500">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15714.243560804638!2d76.3207408!3d10.0530464!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b080dbad294caf9%3A0x725531a46bcef5bb!2sLexus%20Kochi!5e0!3m2!1sen!2sin!4v1732022228738!5m2!1sen!2sin" width="100%" height="540" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-----contact us end------> 
  
</div>
</body>

<!-- Common script -->
<script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script>
var myCarousel = document.querySelector('#carouselInner')
var carousel = new bootstrap.Carousel(carouselInner, {
  interval: 3000,
  pause: false 
})
</script>

<!-- animation -->
<script src="assets/js/aos.js"></script>
<script>
AOS.init();
</script>

<!-- owl carousel -->
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.fancybox.min.js')}}"></script>
<!-- custom -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- header shrink -->
<script>
$(document).on("scroll", function(){
  if
    ($(document).scrollTop() > 86){
    $("#banner").addClass("shrink");
  }
  else
  {
    $("#banner").removeClass("shrink");
  }
});	
</script>
</html>

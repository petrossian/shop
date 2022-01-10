@extends('layouts.app')

@section('content')
    <!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="/img/shop01.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Laptop<br>Collection</h3>
								<a href="/categories/laptops" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="/img/samsung.jpg" alt="">
							</div>
							<div class="shop-body">
								<h3>Phone<br>Collection</h3>
								<a href="/categories/phones" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="/img/64.jpg" alt="">
							</div>
							<div class="shop-body">
								<h3>Planchet<br>Collection</h3>
								<a href="/categories/planchets" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">New Products</h3>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
                                        @foreach ($new_products as $new_product)
                                            <!-- product -->
                                            <div class="product">
                                                <div class="product-img">
                                                    <img src="./img/{{ $new_product->images[0]->file }}" alt="">
                                                    <div class="product-label">
                                                        <span class="sale">-30%</span>
                                                        <span class="new">NEW</span>
                                                    </div>
                                                </div>
                                                <div class="product-body">
                                                    <p class="product-category">
                                                        @foreach ($new_product->categories as $category)
                                                            <span>{{ $category->category }}</span>
                                                        @endforeach
                                                    </p>
                                                    <h3 class="product-name"><a href="#">{{ $new_product->title }}</a></h3>
                                                    <h4 class="product-price">${{ $new_product->price }}</h4>
                                                    <div class="product-btns d-flex justify-content-around">
                                                        @if(!\App\HTTP\Controllers\HomeController::isLiked($new_product->id))
                                                            <form action="/like/{{$new_product->id}}" method="post">
                                                                @csrf
                                                                <button type="submit" style="border:none;">+<i class="fa fa-heart-o"></i></button>
                                                                <sub class="text-danger"><b>{{ \App\HTTP\Controllers\HomeController::likeCount($new_product) }}</b></sub>
                                                            </form>
                                                        @else
                                                            <form action="/unlike/{{$new_product->id}}" method="post">
                                                                @csrf
                                                                <button type="submit" style="border:none;">-<i class="fa fa-heart-o"></i></button>
                                                                <sub class="text-danger"><b>{{ \App\HTTP\Controllers\HomeController::likeCount($new_product) }}</b></sub>
                                                            </form>
                                                        @endif
                                                        <a href="/stripe/{{ $new_product->id }}" class="add-to-chart"><i class="fa fa-shopping-cart"></i></i></a>
                                                        <a href="/show/{{ $new_product->id }}" class="quick-view"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /product -->
                                        @endforeach
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- HOT DEAL SECTION -->
		<div id="hot-deal" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal">
							<ul class="hot-deal-countdown">
								<li>
									<div>
										<h3>02</h3>
										<span>Days</span>
									</div>
								</li>
								<li>
									<div>
										<h3>10</h3>
										<span>Hours</span>
									</div>
								</li>
								<li>
									<div>
										<h3>34</h3>
										<span>Mins</span>
									</div>
								</li>
								<li>
									<div>
										<h3>60</h3>
										<span>Secs</span>
									</div>
								</li>
							</ul>
							<h2 class="text-uppercase">hot deal this week</h2>
							<p>New Collection Up to 50% OFF</p>
							<a class="primary-btn cta-btn" href="/percent-off">Shop now</a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /HOT DEAL SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Top selling</h3>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab2" class="tab-pane fade in active">
									<div class="products-slick" data-nav="#slick-nav-2">
                                        @foreach ($top_products as $product)

                                            <!-- product -->
                                            <div class="product">
                                                <div class="product-img">
                                                    <img src="./img/{{ $product->images[0]->file }}" alt="">
                                                    <div class="product-label">
                                                        <span class="sale">-30%</span>
                                                        <span class="new">NEW</span>
                                                    </div>
                                                </div>
                                                <div class="product-body">
                                                    <p class="product-category">
                                                        @foreach ($product->categories as $category)
                                                            <span>{{ $category->category }}</span>
                                                        @endforeach
                                                    </p>
                                                    <h3 class="product-name"><a href="#">{{ $product->title }}</a></h3>
                                                    <h4 class="product-price">${{ $product->price }}</h4>
                                                    <div class="product-btns d-flex justify-content-around">
                                                        @if(!\App\HTTP\Controllers\HomeController::isLiked($product->id))
                                                            <form action="/like/{{$product->id}}" method="post">
                                                                @csrf
                                                                <button type="submit" style="border:none;">+<i class="fa fa-heart-o"></i></button>
                                                                <sub class="text-danger"><b>{{ \App\HTTP\Controllers\HomeController::likeCount($product) }}</b></sub>
                                                            </form>
                                                        @else
                                                            <form action="/unlike/{{$product->id}}" method="post">
                                                                @csrf
                                                                <button type="submit" style="border:none;">-<i class="fa fa-heart-o"></i></button>
                                                                <sub class="text-danger"><b>{{ \App\HTTP\Controllers\HomeController::likeCount($product) }}</b></sub>
                                                            </form>
                                                        @endif
                                                        <a href="/stripe/{{ $product->id }}" class="add-to-chart">
                                                            <i class="fa fa-shopping-cart"></i></i>
                                                            <sub>{{ $product->sail_count }}</sub>
                                                        </a>
                                                        <a href="/show/{{ $product->id }}" class="quick-view"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /product -->
                                        @endforeach

									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- /Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							<p>Sign Up for the <strong>NEWSLETTER</strong></p>
							<form>
								<input class="input" type="email" placeholder="Enter Your Email">
								<button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
							</form>
							<ul class="newsletter-follow">
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-instagram"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
    <!-- /NEWSLETTER -->
@endsection

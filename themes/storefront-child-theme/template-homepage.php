<?php get_header(); ?>
<div class="container bg-danger">
  <div id="dbsnetCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
      <li data-target="#dbsnetCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#dbsnetCarousel" data-slide-to="1"></li>
      <li data-target="#dbsnetCarousel" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">
      <div class="item active">
        <img alt="nature" src="https://images-na.ssl-images-amazon.com/images/G/01/kindle/merch/2017/SMP/ftvs/popcorngws/1500x300_Lifestyle_v1._CB503869808_.jpg" style="width: 100%">
      </div>
      <div class="item">
        <img alt="fjords" src="https://images-na.ssl-images-amazon.com/images/G/01/AMAZON_FASHION/2017/EDITORIAL/SUMMER_3/GATEWAY/DESKTOP/1x/HERO_W_xCat_ShoppingList2_1x._CB504779749_.jpg" style="width: 100%">
      </div>
      <div class="item">
        <img alt="mountains" src="https://images-na.ssl-images-amazon.com/images/G/01/digital/video/merch/gateway/superhero/Amazon_GW_DesktopHero_AVD-6545_SpongebobSwap_GWAcquisitionTopStreamGrid_V1_1500x300._CB506302663_.jpg" style="width: 100%">
      </div>
    </div>

    <a class="left carousel-control" data-slide="prev" href="#dbsnetCarousel">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" data-slide="next" href="#dbsnetCarousel">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div> <!-- /container -->

<div class="container bg-info">
  <div class="row">
    <div class="col-sm-12 col-lg-6 col-md-6 bg-warning">
      <div>
        <h3>Produk Terbaru</h3>
      </div>
      <ul class="row">
        <?php echo ( do_shortcode('[resent_products]') ); ?>
      </ul>
    </div>

    <div class="col-sm-12 col-lg-6 col-md-6 bg-info">
      <div>
        <h3>Produk Terlaris</h3>
      </div>
      <ul class="row">
        <?php echo ( do_shortcode('[best_sellers]') ); ?>
      </ul>
    </div>
  </div> <!-- /row -->
</div> <!-- /container -->

<div class="container bg-success">
  <div class="row">
    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>

    <div class="col-md-3 col-sm-4">
      <span class="thumbnail">
        <img src="http://placehold.it/500x400" alt="...">
        <h4>Product Tittle</h4>
        <div class="ratings">
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon glyphicon-star-empty"></span>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        <hr class="line">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p class="price">$29,90</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <button class="btn btn-success right" > BUY ITEM</button>
          </div>
        </div>
      </span>
    </div>
  </div>
</div>
<?php get_footer(); ?>

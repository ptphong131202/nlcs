<!-- Slider -->
<div id="carousel-example-generic" class="carousel slide" data-interval="5000" data-bs-ride="carousel">
    <ul class="carousel-indicators">
        <?php
                    $get_slider = $product->show_slider();
                        if($get_slider) {
                            $i = 0;
                            while($result_slider = $get_slider->fetch_assoc()) {
                ?>
        <li data-bs-target="#carousel-example-generic" data-bs-slide-to="<?php echo $i ?>" class="active"></li>
        <?php
                    $i++;
                        }
                    }
                ?>
    </ul>

    <div class="carousel-inner">
        <?php
                    $get_slider = $product->show_slider();
                        if($get_slider) {
                            while($result_slider = $get_slider->fetch_assoc()) {
                ?>
        <div class="carousel-item active">
            <img class="w-100" height="300px" src="admin/uploads/<?php echo $result_slider['slider_image'] ?>" />
        </div>
        <?php
                        }
                    }
                ?>
    </div>

    <a class="carousel-control-prev" href="#carousel-example-generic" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-generic" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>
<hr />
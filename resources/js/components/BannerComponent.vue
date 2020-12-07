<template>
    <div class="contaner-fluid">
        <div id="carouselhome" class="carousel slide carousel-fade w-100 d-block" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselhome" data-slide-to="0"></li>
                <li data-target="#carouselhome" data-slide-to="1"></li>
                <li data-target="#carouselhome" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="/storage/images/layer1.jpg" class="d-block w-100" alt="layer1">
                </div>
                <div class="carousel-item">
                <img src="/storage/images/layer2.jpg" class="d-block w-100" alt="layer2">
                </div>
                <div class="carousel-item">
                <img src="/storage/images/layer3.jpg" class="d-block w-100" alt="layer3">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselhome" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselhome" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</template>

<script>
export default {
  name: 'banner'
}
</script>

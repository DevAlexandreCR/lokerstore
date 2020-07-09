<template>
    <div class="contaner-fluid">
        <div id="carouselhome" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselhome" data-slide-to="0"></li>
                <li data-target="#carouselhome" data-slide-to="1"></li>
                <li data-target="#carouselhome" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="https://cdn.pixabay.com/photo/2015/04/14/16/07/facebook-722283_960_720.jpg" class="img-carousel" alt="">
                </div>
                <div class="carousel-item">
                <img src="https://cdn.pixabay.com/photo/2016/10/15/09/28/fractal-1742109_960_720.jpg" class="img-carousel" alt="">
                </div>
                <div class="carousel-item">
                <img src="https://cdn.pixabay.com/photo/2013/07/12/13/22/chain-146909_960_720.png" class="img-carousel" alt="">
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
        name: 'banner',
        mounted() {
            console.log('Component mounted. banner')
        }
    }
</script>
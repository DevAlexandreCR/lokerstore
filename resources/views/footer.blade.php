<footer id="sticky-footer" class="py-4 text-white-50" 
    style="background-position: center center;
    background-repeat: no-repeat;
    width: 100%;
    z-index: 10;
    background: linear-gradient(to right top, #222222,#000000);">
    <div class="container text-center">
      <small>Copyright &copy; lokerstore.com</small>
      <div class="row">
        <div class="container text-center">
            @if (strpos(Request::url(), 'admin'))
            <a href="{{route('home')}}"><small>Tienda</small></a>
            @else
            <a href="{{route('admin.home')}}"><small>Admin</small></a>
            @endif
            
        </div>
      </div>
    </div>
</footer>
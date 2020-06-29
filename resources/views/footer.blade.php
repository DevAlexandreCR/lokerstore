<footer id="sticky-footer" class="py-4 bg-dark text-white-50" 
    style="background-position: center center;
    background-repeat: no-repeat;
    width: 100%;">
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
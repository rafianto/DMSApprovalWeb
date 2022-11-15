 <footer class="main-footer">
    <strong>Copyright &copy; 2020-2021 <a href="{{ route('home') }}">DMS V.2021 - IT. MBS</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.1 ( {{ \Auth::user()->principal }} / {{ \Auth::user()->site }} {{ substr(strrchr(\Auth::user()->email, "@"), 0) }} )
    </div> 
  </footer>
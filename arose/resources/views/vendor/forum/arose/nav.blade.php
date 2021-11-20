<style>
    .navbar-arose {
        font-size: 16px !important;
        background-color: #a5252d !important;
        box-shadow: none !important;
        background-image: none !important;
    }
    .navbar-arose .navbar-brand{
        font-size: 20px !important;
    }
    .navbar-arose a.nav-link{
        color: rgba(255, 255, 255, 0.9) !important;
        padding-left: 9px !important;
        padding-right: 9px !important;
        text-shadow: none !important;
    }
    .navbar-arose a.nav-link:hover{
        color: rgba(255, 255, 255, 1) !important;
    }
</style>
<nav class="navbar navbar-default navbar-arose" style="border-radius: 0 !important">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Arose Project Webtool</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="nav-item">
              <a class="nav-link" href="/home">Dashboard</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/">Resources</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/students">My Students</a>
          </li>
          <li class="dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Rubrics  <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/rubrics">My Rubrics</a></li>
              <li><a href="/aroserubrics">Arose Rubrics</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Gradebook  <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/rubrics">Grade students</a></li>
              <li><a href="/aroserubrics">Config my gradebook</a></li>
            </ul>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/chat">Chat</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/forum">Forum</a>
          </li>
          <li class="dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name ?: 'Your menu' }}  <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/profile">Edit profile</a></li>
              <li><a href="/logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

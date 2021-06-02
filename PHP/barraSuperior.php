<!--<a id="enlaceInicio" href="index.php" class="navbar-brand">Inicio</a>
<a id="miPerfil" href="" onclick="return modal(this.href)">Mi perfil</a>
<a href="cerrarSesion.php">Cerrar sesion</a>
<form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
</form>
-->
<nav class="navbar navbar-expand-sm navbar-light bg-primary">
  <div class="container-fluid">
    <a id="enlaceInicio" href="index.php" class="navbar-brand">Inicio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-sm-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <!--<a id="miPerfil" href="" class="nav-link active" onclick="return modal(this.href)">Mi perfil</a>-->
          <a id="miPerfil" href="" class="nav-link active">Mi perfil</a>
        </li>
        <li class="nav-item">
          <a id="busquedaPerfil" href="" class="nav-link active" onclick="return modal('PHP/buscar.php')">Busca personas</a>
          <!--<a id="busquedaPerfil" href="" class="nav-link active" onclick="desplegarDetalles('texto')">Busca personas</a>-->
        </li>
        <!--<form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Buscar persona" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>-->
        <li class="nav-item">
          <a class="nav-link active" onclick=cerrarSesion() href="PHP/cerrarSesion.php" tabindex="-1" aria-disabled="true">Cerrar sesión</a>
        </li>
        <!--<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Notificaciones
          </a>
          <ul class="dropdown-menu multi-level" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="#">Por ahora no hay nada</a></li>
            
          </ul>
        </li>-->
        <li class="nav-item dropdown">
          <a id="solicitudesAmistad" class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Solicitudes de amistad
          </a>
          <ul id="listaSolicitudes" class="dropdown-menu multi-level" aria-labelledby="navbarScrollingDropdown">
            <!--<li><a class="dropdown-item" href="#">Por ahora no hay nada</a></li>-->
            <!--<li><hr class="dropdown-divider"></li>-->
          </ul>
        </li>
      </ul>
      
    </div>
  </div>
</nav>
